<?php

declare(strict_types=1);

namespace App\Models;

final class Invoice extends BaseModel
{
    public function createForOrder(int $userId, int $orderId, float $amount): int
    {
        $number = 'INV-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));
        $stmt = $this->pdo->prepare('INSERT INTO invoices (user_id,order_id,invoice_number,amount,status,due_date) VALUES (:user_id,:order_id,:invoice_number,:amount,"pending",DATE_ADD(CURDATE(), INTERVAL 7 DAY))');
        $stmt->execute(['user_id' => $userId, 'order_id' => $orderId, 'invoice_number' => $number, 'amount' => $amount]);
        return (int) $this->pdo->lastInsertId();
    }

    public function allByUser(int $userId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM invoices WHERE user_id=:user_id ORDER BY created_at DESC');
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function findByIdAndUser(int $id, int $userId): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM invoices WHERE id=:id AND user_id=:user_id LIMIT 1');
        $stmt->execute(['id' => $id, 'user_id' => $userId]);
        return $stmt->fetch() ?: null;
    }

    public function markPaid(int $invoiceId): void
    {
        $stmt = $this->pdo->prepare('UPDATE invoices SET status="paid", paid_at=NOW() WHERE id=:id');
        $stmt->execute(['id' => $invoiceId]);
    }

    public function allAdmin(): array
    {
        return $this->pdo->query('SELECT i.*, u.email FROM invoices i JOIN users u ON u.id=i.user_id ORDER BY i.created_at DESC')->fetchAll();
    }
}
