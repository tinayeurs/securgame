<?php

declare(strict_types=1);

namespace App\Models;

final class Payment extends BaseModel
{
    public function create(int $userId, int $invoiceId, float $amount, string $method, string $status = 'pending'): int
    {
        $reference = 'PAY-' . strtoupper(bin2hex(random_bytes(4)));
        $stmt = $this->pdo->prepare('INSERT INTO payments (user_id,invoice_id,transaction_reference,amount,method,status) VALUES (:user_id,:invoice_id,:transaction_reference,:amount,:method,:status)');
        $stmt->execute(['user_id' => $userId, 'invoice_id' => $invoiceId, 'transaction_reference' => $reference, 'amount' => $amount, 'method' => $method, 'status' => $status]);
        return (int) $this->pdo->lastInsertId();
    }

    public function allByUser(int $userId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM payments WHERE user_id=:user_id ORDER BY created_at DESC');
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function allAdmin(): array
    {
        return $this->pdo->query('SELECT p.*, u.email FROM payments p JOIN users u ON u.id=p.user_id ORDER BY p.created_at DESC')->fetchAll();
    }
}
