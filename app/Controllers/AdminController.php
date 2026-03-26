<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Database;
use App\Models\Billing;
use App\Models\Game;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;

final class AdminController extends Controller
{
    private function guard(): void
    {
        if (!Auth::isAdmin()) {
            $this->redirect('/login');
        }
    }

    public function dashboard(): void
    {
        $this->guard();
        $pdo = Database::connection($this->config);
        $stats = [
            'clients' => count((new User($pdo))->allWithRoles()),
            'offers' => count((new Offer($pdo))->allAdmin()),
            'services' => count((new Service($pdo))->allAdmin()),
            'invoices' => count((new Billing($pdo))->allInvoices()),
        ];
        $this->render('admin/dashboard', compact('stats'));
    }

    public function customers(): void
    {
        $this->guard();
        $users = (new User(Database::connection($this->config)))->allWithRoles();
        $this->render('admin/customers', compact('users'));
    }

    public function products(): void
    {
        $this->guard();
        $gameModel = new Game(Database::connection($this->config));

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::validate($_POST['_csrf'] ?? null)) {
                http_response_code(419);
                exit('Invalid CSRF token');
            }
            $name = trim((string) ($_POST['name'] ?? ''));
            $slug = strtolower(trim((string) ($_POST['slug'] ?? '')));
            $description = trim((string) ($_POST['description'] ?? ''));
            if ($name && $slug) {
                $gameModel->create($name, $slug, $description);
            }
            $this->redirect('/admin/products');
        }

        $games = $gameModel->all();
        $this->render('admin/products', compact('games'));
    }

    public function offers(): void
    {
        $this->guard();
        $pdo = Database::connection($this->config);
        $offerModel = new Offer($pdo);
        $gameModel = new Game($pdo);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::validate($_POST['_csrf'] ?? null)) {
                http_response_code(419);
                exit('Invalid CSRF token');
            }
            $offerModel->create([
                'game_id' => (int) ($_POST['game_id'] ?? 0),
                'name' => trim((string) ($_POST['name'] ?? '')),
                'price_monthly' => (float) ($_POST['price_monthly'] ?? 0),
                'ram_mb' => (int) ($_POST['ram_mb'] ?? 0),
                'cpu_cores' => (int) ($_POST['cpu_cores'] ?? 0),
                'storage_gb' => (int) ($_POST['storage_gb'] ?? 0),
                'slots' => (int) ($_POST['slots'] ?? 0),
                'description' => trim((string) ($_POST['description'] ?? '')),
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
            ]);
            $this->redirect('/admin/offers');
        }

        $offers = $offerModel->allAdmin();
        $games = $gameModel->all();
        $this->render('admin/offers', compact('offers', 'games'));
    }

    public function services(): void
    {
        $this->guard();
        $items = (new Service(Database::connection($this->config)))->allAdmin();
        $this->render('admin/services', compact('items'));
    }

    public function orders(): void
    {
        $this->guard();
        $items = (new Order(Database::connection($this->config)))->allAdmin();
        $this->render('admin/orders', compact('items'));
    }

    public function invoices(): void
    {
        $this->guard();
        $billing = new Billing(Database::connection($this->config));
        $invoices = $billing->allInvoices();
        $payments = $billing->allPayments();
        $this->render('admin/invoices', compact('invoices', 'payments'));
    }

    public function integrations(): void
    {
        $this->guard();
        $settingModel = new Setting(Database::connection($this->config));

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::validate($_POST['_csrf'] ?? null)) {
                http_response_code(419);
                exit('Invalid CSRF token');
            }
            $settingModel->updateIntegration('pterodactyl', 'url', trim((string) ($_POST['pterodactyl_url'] ?? '')), (string) ($_POST['mode'] ?? 'test'));
            $settingModel->updateIntegration('pterodactyl', 'api_key', trim((string) ($_POST['pterodactyl_api_key'] ?? '')), (string) ($_POST['mode'] ?? 'test'));
            $settingModel->updateIntegration('stripe', 'public_key', trim((string) ($_POST['stripe_public_key'] ?? '')), (string) ($_POST['mode'] ?? 'test'));
            $settingModel->updateIntegration('stripe', 'secret_key', trim((string) ($_POST['stripe_secret_key'] ?? '')), (string) ($_POST['mode'] ?? 'test'));
            $_SESSION['flash_success'] = 'Paramètres intégrations enregistrés.';
            $this->redirect('/admin/integrations');
        }

        $integrations = $settingModel->allIntegrations();
        $this->render('admin/integrations', compact('integrations'));
    }
}
