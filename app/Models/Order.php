<?php

declare(strict_types=1);

namespace App\Models;

final class Order extends BaseModel
{
    public function create(int $userId, float $total, string $status = 'pending'): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO orders (user_id,total_amount,status) VALUES (:user_id,:total_amount,:status)');
        $stmt->execute(['user_id' => $userId, 'total_amount' => $total, 'status' => $status]);
        return (int) $this->pdo->lastInsertId();
    }

    public function addItem(int $orderId, int $offerId, string $name, float $unitPrice, int $qty = 1): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO order_items (order_id,offer_id,item_name,quantity,unit_price,total_price) VALUES (:order_id,:offer_id,:item_name,:quantity,:unit_price,:total_price)');
        $total = $unitPrice * $qty;
        $stmt->execute(['order_id' => $orderId, 'offer_id' => $offerId, 'item_name' => $name, 'quantity' => $qty, 'unit_price' => $unitPrice, 'total_price' => $total]);
    }

    public function findWithItems(int $id, int $userId): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE id=:id AND user_id=:user_id LIMIT 1');
        $stmt->execute(['id' => $id, 'user_id' => $userId]);
        $order = $stmt->fetch();
        if (!$order) {
            return null;
        }
        $items = $this->pdo->prepare('SELECT * FROM order_items WHERE order_id=:order_id');
        $items->execute(['order_id' => $id]);
        $order['items'] = $items->fetchAll();
        return $order;
    }

    public function allByUser(int $userId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE user_id=:user_id ORDER BY created_at DESC');
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function allAdmin(): array
    {
        return $this->pdo->query('SELECT o.*, u.email FROM orders o JOIN users u ON u.id=o.user_id ORDER BY o.created_at DESC')->fetchAll();
    }

    public function markPaid(int $orderId): void
    {
        $stmt = $this->pdo->prepare('UPDATE orders SET status="paid", paid_at=NOW() WHERE id=:id');
        $stmt->execute(['id' => $orderId]);
    }
}
