<?php

declare(strict_types=1);

namespace App\Models;

final class Offer extends BaseModel
{
    public function publicCatalogue(): array
    {
        $sql = 'SELECT o.*, g.name AS game_name, g.slug AS game_slug FROM offers o JOIN games g ON o.game_id = g.id WHERE o.is_active = 1 AND g.is_active = 1 ORDER BY o.price_monthly ASC';
        return $this->pdo->query($sql)->fetchAll();
    }

    public function byGameSlug(string $slug): array
    {
        $stmt = $this->pdo->prepare('SELECT o.*, g.name AS game_name FROM offers o JOIN games g ON o.game_id = g.id WHERE g.slug = :slug AND o.is_active = 1');
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetchAll();
    }

    public function allAdmin(): array
    {
        $sql = 'SELECT o.id, o.name, g.name AS game_name, o.price_monthly, o.ram_mb, o.cpu_cores, o.storage_gb, o.slots, o.is_active FROM offers o JOIN games g ON o.game_id = g.id ORDER BY o.created_at DESC';
        return $this->pdo->query($sql)->fetchAll();
    }

    public function create(array $data): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO offers (game_id, name, price_monthly, ram_mb, cpu_cores, storage_gb, slots, description, is_active) VALUES (:game_id,:name,:price_monthly,:ram_mb,:cpu_cores,:storage_gb,:slots,:description,:is_active)');
        $stmt->execute($data);
    }
}
