<?php

declare(strict_types=1);

namespace App\Models;

final class Order extends BaseModel
{
    public function clientOrders(int $userId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC');
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function allAdmin(): array
    {
        $sql = 'SELECT o.id, o.status, o.total_amount, u.email FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC';
        return $this->pdo->query($sql)->fetchAll();
    }
}
