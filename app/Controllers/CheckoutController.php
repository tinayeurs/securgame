<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Database;
use App\Models\Invoice;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Payment;
use App\Models\ProvisioningLog;
use App\Models\Service;
use App\Models\Setting;
use App\Services\CheckoutService;
use App\Services\PaymentService;
use App\Services\ProvisioningService;

final class CheckoutController extends Controller
{
    public function configure(): void
    {
        $this->requireClient();
        $offerId = (int) ($_GET['offer_id'] ?? 0);
        $offer = (new Offer(Database::connection($this->config)))->find($offerId);
        if (!$offer) {
            http_response_code(404);
            exit('Offre introuvable');
        }
        $this->render('checkout/configure', compact('offer'));
    }

    public function placeOrder(): void
    {
        $this->requireClient();
        if (!Csrf::validate($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('CSRF invalide');
        }

        $pdo = Database::connection($this->config);
        $offerId = (int) ($_POST['offer_id'] ?? 0);
        $service = new CheckoutService(new Offer($pdo), new Order($pdo), new Invoice($pdo));

        try {
            $result = $service->createOrderFromOffer((int) $this->configClientId(), $offerId);
            $_SESSION['checkout_offer_id'] = $offerId;
            $this->redirect('/checkout/pay?invoice_id=' . $result['invoice_id']);
        } catch (\RuntimeException $e) {
            $_SESSION['flash_error'] = $e->getMessage();
            $this->redirect('/offers');
        }
    }

    public function paymentPage(): void
    {
        $this->requireClient();
        $invoiceId = (int) ($_GET['invoice_id'] ?? 0);
        $invoice = (new Invoice(Database::connection($this->config)))->findByIdAndUser($invoiceId, $this->configClientId());
        if (!$invoice) {
            http_response_code(404);
            exit('Facture introuvable');
        }
        $this->render('checkout/pay', compact('invoice'));
    }

    public function pay(): void
    {
        $this->requireClient();
        if (!Csrf::validate($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('CSRF invalide');
        }

        $pdo = Database::connection($this->config);
        $invoiceId = (int) ($_POST['invoice_id'] ?? 0);
        $offerId = (int) ($_SESSION['checkout_offer_id'] ?? 0);
        $invoice = (new Invoice($pdo))->findByIdAndUser($invoiceId, $this->configClientId());
        if (!$invoice || $offerId <= 0) {
            $_SESSION['flash_error'] = 'Paiement impossible.';
            $this->redirect('/client/invoices');
        }

        $paymentService = new PaymentService(
            new Payment($pdo),
            new Invoice($pdo),
            new Order($pdo),
            new Service($pdo),
            new Setting($pdo),
            new ProvisioningService(new Service($pdo), new ProvisioningLog($pdo), new Offer($pdo)),
            new ProvisioningLog($pdo)
        );

        $paymentService->payInvoice($invoice, $this->configClientId(), (string) ($_POST['method'] ?? 'stripe_test'), $offerId);
        $_SESSION['flash_success'] = 'Paiement confirmé, provisioning lancé.';
        unset($_SESSION['checkout_offer_id']);
        $this->redirect('/client/services');
    }

    private function configClientId(): int
    {
        return (int) ($_SESSION['client_user']['id'] ?? 0);
    }
}
