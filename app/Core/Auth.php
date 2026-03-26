<?php

declare(strict_types=1);

namespace App\Core;

final class Auth
{
    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function isAdmin(): bool
    {
        return self::check() && ($_SESSION['user']['role_name'] ?? '') === 'admin';
    }

    public static function login(array $user): void
    {
        $_SESSION['user'] = [
            'id' => (int) $user['id'],
            'email' => $user['email'],
            'name' => $user['name'],
            'role_name' => $user['role_name'],
        ];
        Session::regenerate();
    }

    public static function logout(): void
    {
        unset($_SESSION['user']);
        Session::regenerate();
    }
}
