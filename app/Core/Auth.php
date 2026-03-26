<?php

declare(strict_types=1);

namespace App\Core;

final class Auth
{
    public static function client(): ?array
    {
        return $_SESSION['client_user'] ?? null;
    }

    public static function admin(): ?array
    {
        return $_SESSION['admin_user'] ?? null;
    }

    public static function checkClient(): bool
    {
        return self::client() !== null;
    }

    public static function checkAdmin(): bool
    {
        return self::admin() !== null;
    }

    public static function loginClient(array $user): void
    {
        $_SESSION['client_user'] = [
            'id' => (int) $user['id'],
            'email' => $user['email'],
            'name' => $user['name'],
            'customer_id' => (int) ($user['customer_id'] ?? 0),
        ];
        Session::regenerate();
    }

    public static function loginAdmin(array $admin): void
    {
        $_SESSION['admin_user'] = [
            'id' => (int) $admin['id'],
            'email' => $admin['email'],
            'name' => $admin['name'],
            'role' => $admin['role_name'],
        ];
        Session::regenerate();
    }

    public static function logoutClient(): void
    {
        unset($_SESSION['client_user']);
        Session::regenerate();
    }

    public static function logoutAdmin(): void
    {
        unset($_SESSION['admin_user']);
        Session::regenerate();
    }
}
