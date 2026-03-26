<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Database;
use App\Core\Validator;
use App\Models\User;

final class AuthController extends Controller
{
    public function loginForm(): void
    {
        $this->render('auth/client-login');
    }

    public function login(): void
    {
        if (!Csrf::validate($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('CSRF invalide');
        }

        $email = strtolower(trim((string) ($_POST['email'] ?? '')));
        $password = (string) ($_POST['password'] ?? '');

        $user = (new User(Database::connection($this->config)))->findClientByEmail($email);
        if (!$user || !password_verify($password, $user['password_hash'])) {
            $_SESSION['flash_error'] = 'Identifiants client invalides.';
            $this->redirect('/login');
        }

        Auth::loginClient($user);
        $this->redirect('/client');
    }

    public function registerForm(): void
    {
        $this->render('auth/register');
    }

    public function register(): void
    {
        if (!Csrf::validate($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('CSRF invalide');
        }

        $name = trim((string) ($_POST['name'] ?? ''));
        $email = strtolower(trim((string) ($_POST['email'] ?? '')));
        $password = (string) ($_POST['password'] ?? '');

        if (!Validator::required($name) || !Validator::email($email) || strlen($password) < 8) {
            $_SESSION['flash_error'] = 'Formulaire invalide.';
            $this->redirect('/register');
        }

        $users = new User(Database::connection($this->config));
        if ($users->findClientByEmail($email)) {
            $_SESSION['flash_error'] = 'Email déjà utilisé.';
            $this->redirect('/register');
        }

        $users->createClient($name, $email, password_hash($password, PASSWORD_DEFAULT));
        $_SESSION['flash_success'] = 'Compte créé. Connectez-vous.';
        $this->redirect('/login');
    }

    public function logout(): void
    {
        Auth::logoutClient();
        $this->redirect('/');
    }
}
