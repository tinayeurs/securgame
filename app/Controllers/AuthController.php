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
    public function showLogin(): void
    {
        $this->render('auth/login');
    }

    public function login(): void
    {
        if (!Csrf::validate($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('Invalid CSRF token');
        }

        $email = strtolower(trim((string) ($_POST['email'] ?? '')));
        $password = (string) ($_POST['password'] ?? '');

        $userModel = new User(Database::connection($this->config));
        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            $_SESSION['flash_error'] = 'Identifiants invalides.';
            $this->redirect('/login');
        }

        Auth::login($user);
        $this->redirect(Auth::isAdmin() ? '/admin' : '/client');
    }

    public function showRegister(): void
    {
        $this->render('auth/register');
    }

    public function register(): void
    {
        if (!Csrf::validate($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('Invalid CSRF token');
        }

        $name = trim((string) ($_POST['name'] ?? ''));
        $email = strtolower(trim((string) ($_POST['email'] ?? '')));
        $password = (string) ($_POST['password'] ?? '');

        if (!Validator::required($name) || !Validator::email($email) || strlen($password) < 8) {
            $_SESSION['flash_error'] = 'Formulaire invalide (nom, email valide, mot de passe >= 8).';
            $this->redirect('/register');
        }

        $userModel = new User(Database::connection($this->config));
        if ($userModel->findByEmail($email)) {
            $_SESSION['flash_error'] = 'Email déjà utilisé.';
            $this->redirect('/register');
        }

        $userModel->createCustomer($name, $email, password_hash($password, PASSWORD_DEFAULT));
        $_SESSION['flash_success'] = 'Compte créé. Connectez-vous.';
        $this->redirect('/login');
    }

    public function logout(): void
    {
        Auth::logout();
        $this->redirect('/');
    }

    public function forgotPassword(): void
    {
        $this->render('auth/forgot-password');
    }
}
