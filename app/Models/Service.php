<?php

declare(strict_types=1);

namespace App\Models;

final class Service extends BaseModel
{
    public function createFromOrder(int $userId, int $orderId, int $offerId): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO services (user_id,order_id,offer_id,status,provisioning_status,expires_at) VALUES (:user_id,:order_id,:offer_id,"pending","pending",DATE_ADD(NOW(), INTERVAL 30 DAY))');
        $stmt->execute(['user_id' => $userId, 'order_id' => $orderId, 'offer_id' => $offerId]);
        return (int) $this->pdo->lastInsertId();
    }

    public function updateProvisioning(int $serviceId, string $provisioningStatus, string $serviceStatus): void
    {
        $stmt = $this->pdo->prepare('UPDATE services SET provisioning_status=:provisioning_status, status=:status WHERE id=:id');
        $stmt->execute(['id' => $serviceId, 'provisioning_status' => $provisioningStatus, 'status' => $serviceStatus]);
    }

    public function allByUser(int $userId): array
    {
        $sql = 'SELECT s.*, o.name AS offer_name, o.ram_mb, o.cpu_cores, o.storage_gb, o.slots, p.name AS product_name, g.name AS game_name
                FROM services s
                JOIN offers o ON o.id=s.offer_id
                JOIN products p ON p.id=o.product_id
                JOIN games g ON g.id=p.game_id
                WHERE s.user_id=:user_id
                ORDER BY s.created_at DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function findByIdAndUser(int $id, int $userId): ?array
    {
        $sql = 'SELECT s.*, o.name AS offer_name, o.description AS offer_description, o.ram_mb, o.cpu_cores, o.storage_gb, o.slots, p.name AS product_name, g.name AS game_name
                FROM services s
                JOIN offers o ON o.id=s.offer_id
                JOIN products p ON p.id=o.product_id
                JOIN games g ON g.id=p.game_id
                WHERE s.id=:id AND s.user_id=:user_id LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id, 'user_id' => $userId]);
        return $stmt->fetch() ?: null;
    }

    public function allAdmin(): array
    {
        $sql = 'SELECT s.*, u.email, o.name AS offer_name FROM services s JOIN users u ON u.id=s.user_id JOIN offers o ON o.id=s.offer_id ORDER BY s.created_at DESC';
        return $this->pdo->query($sql)->fetchAll();
    }
}
