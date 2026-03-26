<?php

declare(strict_types=1);

namespace App\Models;

final class Setting extends BaseModel
{
    public function get(string $key, ?string $default = null): ?string
    {
        $stmt = $this->pdo->prepare('SELECT value FROM settings WHERE `key` = :key LIMIT 1');
        $stmt->execute(['key' => $key]);
        $value = $stmt->fetchColumn();
        return $value !== false ? (string) $value : $default;
    }

    public function upsert(string $key, string $value): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO settings (`key`, value) VALUES (:key, :value) ON DUPLICATE KEY UPDATE value = :value2');
        $stmt->execute(['key' => $key, 'value' => $value, 'value2' => $value]);
    }

    public function allIntegrations(): array
    {
        $rows = $this->pdo->query("SELECT provider, config_key, config_value, mode, is_configured FROM external_integrations ORDER BY provider, config_key")->fetchAll();
        $result = [];
        foreach ($rows as $row) {
            $result[$row['provider']][] = $row;
        }
        return $result;
    }

    public function updateIntegration(string $provider, string $key, string $value, string $mode): void
    {
        $stmt = $this->pdo->prepare('UPDATE external_integrations SET config_value = :value, mode = :mode, is_configured = CASE WHEN :value2 = "" THEN 0 ELSE 1 END WHERE provider = :provider AND config_key = :config_key');
        $stmt->execute([
            'value' => $value,
            'value2' => $value,
            'mode' => $mode,
            'provider' => $provider,
            'config_key' => $key,
        ]);
    }
}
