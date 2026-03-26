<?php

declare(strict_types=1);

namespace App\Models;

final class Billing extends BaseModel
{
    public function clientInvoices(int $userId): array
    {
        $stmt = $this->pdo->prepare('SELECT i.* FROM invoices i WHERE i.user_id = :user_id ORDER BY i.created_at DESC');
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function clientPayments(int $userId): array
    {
        $stmt = $this->pdo->prepare('SELECT p.* FROM payments p WHERE p.user_id = :user_id ORDER BY p.created_at DESC');
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function allInvoices(): array
    {
        $sql = 'SELECT i.id, i.invoice_number, i.amount, i.status, i.due_date, u.email FROM invoices i JOIN users u ON i.user_id = u.id ORDER BY i.created_at DESC';
        return $this->pdo->query($sql)->fetchAll();
    }

    public function allPayments(): array
    {
        $sql = 'SELECT p.id, p.transaction_reference, p.amount, p.method, p.status, u.email FROM payments p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC';
        return $this->pdo->query($sql)->fetchAll();
    }
}
