<?php

declare(strict_types=1);

namespace App\Models;

final class Service extends BaseModel
{
    public function clientServices(int $userId): array
    {
        $sql = 'SELECT s.*, o.name AS offer_name, g.name AS game_name FROM services s JOIN offers o ON s.offer_id = o.id JOIN games g ON o.game_id = g.id WHERE s.user_id = :user_id ORDER BY s.created_at DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function allAdmin(): array
    {
        $sql = 'SELECT s.id, s.status, s.expires_at, u.email, o.name AS offer_name FROM services s JOIN users u ON s.user_id = u.id JOIN offers o ON s.offer_id = o.id ORDER BY s.created_at DESC';
        return $this->pdo->query($sql)->fetchAll();
    }
}
