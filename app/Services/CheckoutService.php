<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Invoice;
use App\Models\Offer;
use App\Models\Order;

final class CheckoutService
{
    private Offer $offers;
    private Order $orders;
    private Invoice $invoices;

    public function __construct(Offer $offers, Order $orders, Invoice $invoices)
    {
        $this->offers = $offers;
        $this->orders = $orders;
        $this->invoices = $invoices;
    }

    public function createOrderFromOffer(int $userId, int $offerId): array
    {
        $offer = $this->offers->find($offerId);
        if (!$offer || (int) $offer['is_active'] !== 1) {
            throw new \RuntimeException('Offre indisponible.');
        }

        $total = (float) $offer['price_monthly'] + (float) $offer['setup_fee'];
        $orderId = $this->orders->create($userId, $total, 'pending');
        $this->orders->addItem($orderId, $offerId, $offer['name'], (float) $offer['price_monthly'], 1);
        $invoiceId = $this->invoices->createForOrder($userId, $orderId, $total);

        return ['order_id' => $orderId, 'invoice_id' => $invoiceId, 'total' => $total, 'offer' => $offer];
    }
}
