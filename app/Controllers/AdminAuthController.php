<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Database;
use App\Models\AdminUser;

final class AdminAuthController extends Controller
{
    public function loginForm(): void
    {
        $this->render('auth/admin-login');
    }

    public function login(): void
    {
        if (!Csrf::validate($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('CSRF invalide');
        }

        $email = strtolower(trim((string) ($_POST['email'] ?? '')));
        $password = (string) ($_POST['password'] ?? '');
        $admin = (new AdminUser(Database::connection($this->config)))->findByEmail($email);

        if (!$admin || !password_verify($password, $admin['password_hash']) || $admin['status'] !== 'active') {
            $_SESSION['flash_error'] = 'Identifiants administrateur invalides.';
            $this->redirect('/admin/login');
        }

        Auth::loginAdmin($admin);
        $this->redirect('/admin');
    }

    public function logout(): void
    {
        Auth::logoutAdmin();
        $this->redirect('/admin/login');
    }
}
