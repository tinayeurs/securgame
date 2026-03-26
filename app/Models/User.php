<?php

declare(strict_types=1);

namespace App\Models;

final class User extends BaseModel
{
    public function findClientByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare('SELECT u.id, u.name, u.email, u.password_hash, c.id AS customer_id FROM users u JOIN customers c ON c.user_id = u.id WHERE u.email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch() ?: null;
    }

    public function createClient(string $name, string $email, string $passwordHash): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO users (name, email, password_hash, status) VALUES (:name,:email,:password_hash,"active")');
        $stmt->execute(['name' => $name, 'email' => $email, 'password_hash' => $passwordHash]);
        $userId = (int) $this->pdo->lastInsertId();

        $customerStmt = $this->pdo->prepare('INSERT INTO customers (user_id, company_name, phone, billing_address) VALUES (:user_id, NULL, NULL, NULL)');
        $customerStmt->execute(['user_id' => $userId]);

        return $userId;
    }

    public function updateClient(int $id, string $name, string $email): void
    {
        $stmt = $this->pdo->prepare('UPDATE users SET name=:name, email=:email WHERE id=:id');
        $stmt->execute(compact('id', 'name', 'email'));
    }

    public function allClients(): array
    {
        return $this->pdo->query('SELECT u.id, u.name, u.email, u.status, u.created_at FROM users u ORDER BY u.created_at DESC')->fetchAll();
    }
}
