<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Database;
use App\Core\Validator;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use App\Models\ProvisioningLog;
use App\Models\Service;
use App\Models\User;

final class ClientController extends Controller
{
    public function dashboard(): void
    {
        $this->requireClient();
        $pdo = Database::connection($this->config);
        $userId = (int) $_SESSION['client_user']['id'];

        $services = (new Service($pdo))->allByUser($userId);
        $orders = (new Order($pdo))->allByUser($userId);
        $invoices = (new Invoice($pdo))->allByUser($userId);
        $payments = (new Payment($pdo))->allByUser($userId);

        $this->render('client/dashboard', compact('services', 'orders', 'invoices', 'payments'));
    }

    public function services(): void
    {
        $this->requireClient();
        $services = (new Service(Database::connection($this->config)))->allByUser((int) $_SESSION['client_user']['id']);
        $this->render('client/services', compact('services'));
    }

    public function serviceDetail(): void
    {
        $this->requireClient();
        $pdo = Database::connection($this->config);
        $id = (int) ($_GET['id'] ?? 0);
        $service = (new Service($pdo))->findByIdAndUser($id, (int) $_SESSION['client_user']['id']);
        if (!$service) {
            http_response_code(404);
            exit('Service introuvable');
        }

        $logs = (new ProvisioningLog($pdo))->byService($id);
        $this->render('client/service-detail', compact('service', 'logs'));
    }

    public function orders(): void
    {
        $this->requireClient();
        $orders = (new Order(Database::connection($this->config)))->allByUser((int) $_SESSION['client_user']['id']);
        $this->render('client/orders', compact('orders'));
    }

    public function invoices(): void
    {
        $this->requireClient();
        $pdo = Database::connection($this->config);
        $items = (new Invoice($pdo))->allByUser((int) $_SESSION['client_user']['id']);
        $payments = (new Payment($pdo))->allByUser((int) $_SESSION['client_user']['id']);
        $this->render('client/invoices', compact('items', 'payments'));
    }

    public function profile(): void
    {
        $this->requireClient();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::validate($_POST['_csrf'] ?? null)) {
                http_response_code(419);
                exit('CSRF invalide');
            }
            $name = trim((string) ($_POST['name'] ?? ''));
            $email = trim((string) ($_POST['email'] ?? ''));
            if (!Validator::required($name) || !Validator::email($email)) {
                $_SESSION['flash_error'] = 'Profil invalide.';
                $this->redirect('/client/profile');
            }

            (new User(Database::connection($this->config)))->updateClient((int) $_SESSION['client_user']['id'], $name, $email);
            $_SESSION['client_user']['name'] = $name;
            $_SESSION['client_user']['email'] = $email;
            $_SESSION['flash_success'] = 'Profil mis à jour.';
            $this->redirect('/client/profile');
        }

        $this->render('client/profile');
    }
}
