<?php

declare(strict_types=1);

namespace App\Models;

final class Offer extends BaseModel
{
    public function byProduct(int $productId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM offers WHERE product_id = :product_id AND is_active=1 ORDER BY price_monthly ASC');
        $stmt->execute(['product_id' => $productId]);
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT o.*, p.name AS product_name, g.name AS game_name FROM offers o JOIN products p ON o.product_id=p.id JOIN games g ON p.game_id=g.id WHERE o.id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function allCatalogue(): array
    {
        $sql = 'SELECT o.*, p.name AS product_name, g.name AS game_name, p.slug AS product_slug, g.slug AS game_slug FROM offers o JOIN products p ON p.id=o.product_id JOIN games g ON g.id=p.game_id WHERE o.is_active=1 AND p.is_active=1 AND g.is_active=1 ORDER BY g.name, o.price_monthly';
        return $this->pdo->query($sql)->fetchAll();
    }

    public function allAdmin(): array
    {
        $sql = 'SELECT o.id, o.name, o.price_monthly, o.ram_mb, o.cpu_cores, o.storage_gb, o.slots, o.status, p.name AS product_name, g.name AS game_name FROM offers o JOIN products p ON p.id=o.product_id JOIN games g ON g.id=p.game_id ORDER BY o.created_at DESC';
        return $this->pdo->query($sql)->fetchAll();
    }

    public function create(array $data): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO offers (product_id,name,description,price_monthly,setup_fee,ram_mb,cpu_cores,storage_gb,slots,status,is_active,ptero_egg_id,ptero_nest_id,ptero_location_id) VALUES (:product_id,:name,:description,:price_monthly,:setup_fee,:ram_mb,:cpu_cores,:storage_gb,:slots,:status,:is_active,:ptero_egg_id,:ptero_nest_id,:ptero_location_id)');
        $stmt->execute($data);
    }
}
