<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Database;
use App\Models\AdminUser;
use App\Models\Game;
use App\Models\Invoice;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;

final class AdminController extends Controller
{
    public function dashboard(): void
    {
        $this->requireAdmin();
        $pdo = Database::connection($this->config);
        $stats = [
            'clients' => count((new User($pdo))->allClients()),
            'admins' => count((new AdminUser($pdo))->all()),
            'products' => count((new Product($pdo))->allAdmin()),
            'offers' => count((new Offer($pdo))->allAdmin()),
            'orders' => count((new Order($pdo))->allAdmin()),
            'services' => count((new Service($pdo))->allAdmin()),
            'invoices' => count((new Invoice($pdo))->allAdmin()),
            'payments' => count((new Payment($pdo))->allAdmin()),
        ];
        $this->render('admin/dashboard', compact('stats'));
    }

    public function clients(): void
    {
        $this->requireAdmin();
        $clients = (new User(Database::connection($this->config)))->allClients();
        $this->render('admin/clients', compact('clients'));
    }

    public function admins(): void
    {
        $this->requireAdmin();
        $admins = (new AdminUser(Database::connection($this->config)))->all();
        $this->render('admin/admins', compact('admins'));
    }

    public function games(): void
    {
        $this->requireAdmin();
        $model = new Game(Database::connection($this->config));
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::validate($_POST['_csrf'] ?? null)) {
                http_response_code(419);
                exit('CSRF invalide');
            }
            $model->create(trim((string) $_POST['name']), trim((string) $_POST['slug']), trim((string) $_POST['description']));
            $_SESSION['flash_success'] = 'Jeu ajouté.';
            $this->redirect('/admin/games');
        }
        $games = $model->allAdmin();
        $this->render('admin/games', compact('games'));
    }

    public function products(): void
    {
        $this->requireAdmin();
        $pdo = Database::connection($this->config);
        $model = new Product($pdo);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::validate($_POST['_csrf'] ?? null)) {
                http_response_code(419);
                exit('CSRF invalide');
            }
            $model->create([
                'game_id' => (int) $_POST['game_id'],
                'name' => trim((string) $_POST['name']),
                'slug' => trim((string) $_POST['slug']),
                'description' => trim((string) $_POST['description']),
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
                'sort_order' => (int) ($_POST['sort_order'] ?? 0),
            ]);
            $_SESSION['flash_success'] = 'Produit ajouté.';
            $this->redirect('/admin/products');
        }
        $products = $model->allAdmin();
        $games = (new Game($pdo))->allAdmin();
        $this->render('admin/products', compact('products', 'games'));
    }

    public function offers(): void
    {
        $this->requireAdmin();
        $pdo = Database::connection($this->config);
        $model = new Offer($pdo);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::validate($_POST['_csrf'] ?? null)) {
                http_response_code(419);
                exit('CSRF invalide');
            }
            $model->create([
                'product_id' => (int) $_POST['product_id'],
                'name' => trim((string) $_POST['name']),
                'description' => trim((string) $_POST['description']),
                'price_monthly' => (float) $_POST['price_monthly'],
                'setup_fee' => (float) $_POST['setup_fee'],
                'ram_mb' => (int) $_POST['ram_mb'],
                'cpu_cores' => (int) $_POST['cpu_cores'],
                'storage_gb' => (int) $_POST['storage_gb'],
                'slots' => (int) $_POST['slots'],
                'status' => (string) ($_POST['status'] ?? 'active'),
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
                'ptero_egg_id' => (int) ($_POST['ptero_egg_id'] ?? 0),
                'ptero_nest_id' => (int) ($_POST['ptero_nest_id'] ?? 0),
                'ptero_location_id' => (int) ($_POST['ptero_location_id'] ?? 0),
            ]);
            $_SESSION['flash_success'] = 'Offre ajoutée.';
            $this->redirect('/admin/offers');
        }
        $offers = $model->allAdmin();
        $products = (new Product($pdo))->allAdmin();
        $this->render('admin/offers', compact('offers', 'products'));
    }

    public function orders(): void
    {
        $this->requireAdmin();
        $orders = (new Order(Database::connection($this->config)))->allAdmin();
        $this->render('admin/orders', compact('orders'));
    }

    public function services(): void
    {
        $this->requireAdmin();
        $services = (new Service(Database::connection($this->config)))->allAdmin();
        $this->render('admin/services', compact('services'));
    }

    public function billing(): void
    {
        $this->requireAdmin();
        $pdo = Database::connection($this->config);
        $invoices = (new Invoice($pdo))->allAdmin();
        $payments = (new Payment($pdo))->allAdmin();
        $this->render('admin/billing', compact('invoices', 'payments'));
    }

    public function integrations(): void
    {
        $this->requireAdmin();
        $settings = new Setting(Database::connection($this->config));

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::validate($_POST['_csrf'] ?? null)) {
                http_response_code(419);
                exit('CSRF invalide');
            }
            $mode = (string) ($_POST['mode'] ?? 'test');
            $settings->setIntegration('pterodactyl', 'panel_name', trim((string) $_POST['panel_name']), $mode);
            $settings->setIntegration('pterodactyl', 'panel_url', trim((string) $_POST['panel_url']), $mode);
            $settings->setIntegration('pterodactyl', 'api_key', trim((string) $_POST['api_key']), $mode);
            $settings->setIntegration('stripe', 'public_key', trim((string) $_POST['stripe_public']), $mode);
            $settings->setIntegration('stripe', 'secret_key', trim((string) $_POST['stripe_secret']), $mode);
            $settings->setIntegration('stripe', 'webhook_secret', trim((string) $_POST['stripe_webhook']), $mode);
            $_SESSION['flash_success'] = 'Paramètres enregistrés.';
            $this->redirect('/admin/integrations');
        }

        $integrationSettings = $settings->allIntegrationSettings();
        $this->render('admin/integrations', compact('integrationSettings'));
    }
}
