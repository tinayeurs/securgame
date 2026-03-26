<?php

declare(strict_types=1);

namespace App\Core;

final class Session
{
    public static function start(array $config): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        session_name('securgame_main');
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        session_start();

        $_SESSION['security'] ??= [
            'client_session_key' => $config['security']['client_session'] ?? 'securgame_client',
            'admin_session_key' => $config['security']['admin_session'] ?? 'securgame_admin',
        ];
    }

    public static function regenerate(): void
    {
        session_regenerate_id(true);
    }
}
