<?php

declare(strict_types=1);

return [
    'app' => [
        'name' => 'SecurGame',
        'url' => 'http://localhost:8000',
        'env' => 'local',
        'debug' => true,
        'session_name' => 'securgame_session',
    ],
    'db' => [
        'host' => '127.0.0.1',
        'port' => 3306,
        'database' => 'securgame',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
    ],
];
