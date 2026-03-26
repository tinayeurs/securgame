<?php

declare(strict_types=1);

namespace App\Models;

final class AdminUser extends BaseModel
{
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM admin_users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch() ?: null;
    }

    public function all(): array
    {
        return $this->pdo->query('SELECT id, name, email, role_name, status, created_at FROM admin_users ORDER BY created_at DESC')->fetchAll();
    }
}
