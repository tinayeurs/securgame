<?php

declare(strict_types=1);

namespace App\Models;

final class User extends BaseModel
{
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare('SELECT u.id, u.email, u.password_hash, u.name, r.name AS role_name FROM users u JOIN roles r ON u.role_id = r.id WHERE u.email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch() ?: null;
    }

    public function createCustomer(string $name, string $email, string $passwordHash): int
    {
        $roleStmt = $this->pdo->prepare('SELECT id FROM roles WHERE name = :name LIMIT 1');
        $roleStmt->execute(['name' => 'client']);
        $roleId = (int) $roleStmt->fetchColumn();

        $stmt = $this->pdo->prepare('INSERT INTO users (role_id, name, email, password_hash) VALUES (:role_id, :name, :email, :password_hash)');
        $stmt->execute([
            'role_id' => $roleId,
            'name' => $name,
            'email' => $email,
            'password_hash' => $passwordHash,
        ]);

        $userId = (int) $this->pdo->lastInsertId();
        $customer = $this->pdo->prepare('INSERT INTO customers (user_id, company_name, phone, billing_address) VALUES (:user_id, :company_name, :phone, :billing_address)');
        $customer->execute([
            'user_id' => $userId,
            'company_name' => null,
            'phone' => null,
            'billing_address' => null,
        ]);

        return $userId;
    }

    public function updateProfile(int $id, string $name, string $email): void
    {
        $stmt = $this->pdo->prepare('UPDATE users SET name = :name, email = :email WHERE id = :id');
        $stmt->execute(['id' => $id, 'name' => $name, 'email' => $email]);
    }

    public function allWithRoles(): array
    {
        $stmt = $this->pdo->query('SELECT u.id, u.name, u.email, r.name AS role_name, u.created_at FROM users u JOIN roles r ON u.role_id = r.id ORDER BY u.created_at DESC');
        return $stmt->fetchAll();
    }
}
