<?php

declare(strict_types=1);

namespace App\Models;

final class Game extends BaseModel
{
    public function allActive(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM games WHERE is_active = 1 ORDER BY name ASC');
        return $stmt->fetchAll();
    }

    public function all(): array
    {
        return $this->pdo->query('SELECT * FROM games ORDER BY created_at DESC')->fetchAll();
    }

    public function create(string $name, string $slug, string $description): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO games (name, slug, description, is_active) VALUES (:name, :slug, :description, 1)');
        $stmt->execute(compact('name', 'slug', 'description'));
    }
}
