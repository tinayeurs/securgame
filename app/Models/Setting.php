<?php

declare(strict_types=1);

namespace App\Models;

final class Setting extends BaseModel
{
    public function allIntegrationSettings(): array
    {
        $rows = $this->pdo->query('SELECT * FROM integration_settings ORDER BY provider, config_key')->fetchAll();
        $grouped = [];
        foreach ($rows as $row) {
            $grouped[$row['provider']][$row['config_key']] = $row;
        }
        return $grouped;
    }

    public function setIntegration(string $provider, string $configKey, string $configValue, string $mode): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO integration_settings (provider,config_key,config_value,mode,connection_status,is_configured) VALUES (:provider,:config_key,:config_value,:mode,"not_configured",CASE WHEN :config_value2="" THEN 0 ELSE 1 END) ON DUPLICATE KEY UPDATE config_value=:config_value_upd, mode=:mode_upd, is_configured=CASE WHEN :config_value3="" THEN 0 ELSE 1 END');
        $stmt->execute([
            'provider' => $provider,
            'config_key' => $configKey,
            'config_value' => $configValue,
            'config_value2' => $configValue,
            'config_value_upd' => $configValue,
            'mode_upd' => $mode,
            'config_value3' => $configValue,
            'mode' => $mode,
        ]);
    }

    public function allSiteSettings(): array
    {
        return $this->pdo->query('SELECT * FROM site_settings ORDER BY setting_key')->fetchAll();
    }
}
