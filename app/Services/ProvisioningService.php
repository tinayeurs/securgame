<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Offer;
use App\Models\ProvisioningLog;
use App\Models\Service;

final class ProvisioningService
{
    private Service $services;
    private ProvisioningLog $logs;
    private Offer $offers;

    public function __construct(Service $services, ProvisioningLog $logs, Offer $offers)
    {
        $this->services = $services;
        $this->logs = $logs;
        $this->offers = $offers;
    }

    public function provision(int $serviceId, int $offerId, array $integrationSettings): void
    {
        $this->services->updateProvisioning($serviceId, 'provisioning', 'provisioning');
        $this->logs->log($serviceId, 'provisioning', 'Démarrage du provisioning automatique.');

        $pteroUrl = $integrationSettings['pterodactyl']['panel_url']['config_value'] ?? '';
        $pteroKey = $integrationSettings['pterodactyl']['api_key']['config_value'] ?? '';

        if ($pteroUrl === '' || $pteroKey === '') {
            $this->services->updateProvisioning($serviceId, 'failed', 'pending');
            $this->logs->log($serviceId, 'failed', 'Pterodactyl non configuré. Service laissé en attente.');
            return;
        }

        $offer = $this->offers->find($offerId);
        if (!$offer) {
            $this->services->updateProvisioning($serviceId, 'failed', 'failed');
            $this->logs->log($serviceId, 'failed', 'Offre introuvable pour le provisioning.');
            return;
        }

        // Mock prêt à être remplacé par appel API réel Pterodactyl.
        $this->logs->log($serviceId, 'provisioning', 'Simulation API Pterodactyl: création serveur.');
        $this->services->updateProvisioning($serviceId, 'active', 'active');
        $this->logs->log($serviceId, 'active', 'Serveur provisionné et activé avec succès.');
    }
}
