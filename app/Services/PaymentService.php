<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use App\Models\ProvisioningLog;
use App\Models\Service;
use App\Models\Setting;

final class PaymentService
{
    private Payment $payments;
    private Invoice $invoices;
    private Order $orders;
    private Service $services;
    private Setting $settings;
    private ProvisioningService $provisioning;
    private ProvisioningLog $logs;

    public function __construct(
        Payment $payments,
        Invoice $invoices,
        Order $orders,
        Service $services,
        Setting $settings,
        ProvisioningService $provisioning,
        ProvisioningLog $logs
    ) {
        $this->payments = $payments;
        $this->invoices = $invoices;
        $this->orders = $orders;
        $this->services = $services;
        $this->settings = $settings;
        $this->provisioning = $provisioning;
        $this->logs = $logs;
    }

    public function payInvoice(array $invoice, int $userId, string $method, int $offerId): int
    {
        $paymentId = $this->payments->create($userId, (int) $invoice['id'], (float) $invoice['amount'], $method, 'paid');
        $this->invoices->markPaid((int) $invoice['id']);
        $this->orders->markPaid((int) $invoice['order_id']);

        $serviceId = $this->services->createFromOrder($userId, (int) $invoice['order_id'], $offerId);
        $this->logs->log($serviceId, 'pending', 'Paiement validé, service en file de provisioning.');

        $integrationSettings = $this->settings->allIntegrationSettings();
        $this->provisioning->provision($serviceId, $offerId, $integrationSettings);

        return $paymentId;
    }
}
