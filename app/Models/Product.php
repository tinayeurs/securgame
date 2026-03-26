<?php

declare(strict_types=1);

namespace App\Models;

final class Product extends BaseModel
{
    public function allActive(): array
    {
        $sql = 'SELECT p.*, g.name AS game_name, g.slug AS game_slug FROM products p JOIN games g ON g.id = p.game_id WHERE p.is_active=1 AND g.is_active=1 ORDER BY p.sort_order ASC';
        return $this->pdo->query($sql)->fetchAll();
    }

    public function allAdmin(): array
    {
        $sql = 'SELECT p.*, g.name AS game_name FROM products p JOIN games g ON p.game_id = g.id ORDER BY p.created_at DESC';
        return $this->pdo->query($sql)->fetchAll();
    }

    public function create(array $data): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO products (game_id,name,slug,description,is_active,sort_order) VALUES (:game_id,:name,:slug,:description,:is_active,:sort_order)');
        $stmt->execute($data);
    }
}
