<?php

declare(strict_types=1);

namespace App\Models;

final class ProvisioningLog extends BaseModel
{
    public function log(int $serviceId, string $status, string $message): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO service_provisioning_logs (service_id,status,message) VALUES (:service_id,:status,:message)');
        $stmt->execute(['service_id' => $serviceId, 'status' => $status, 'message' => $message]);
    }

    public function byService(int $serviceId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM service_provisioning_logs WHERE service_id=:service_id ORDER BY created_at DESC');
        $stmt->execute(['service_id' => $serviceId]);
        return $stmt->fetchAll();
    }
}
