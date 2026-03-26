<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Database;
use App\Core\Validator;
use App\Models\Billing;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;

final class ClientController extends Controller
{
    private function guard(): void
    {
        if (!Auth::check()) {
            $this->redirect('/login');
        }
    }

    public function dashboard(): void
    {
        $this->guard();
        $pdo = Database::connection($this->config);
        $userId = (int) Auth::user()['id'];
        $services = (new Service($pdo))->clientServices($userId);
        $orders = (new Order($pdo))->clientOrders($userId);
        $invoices = (new Billing($pdo))->clientInvoices($userId);
        $this->render('client/dashboard', compact('services', 'orders', 'invoices'));
    }

    public function invoices(): void
    {
        $this->guard();
        $billing = new Billing(Database::connection($this->config));
        $items = $billing->clientInvoices((int) Auth::user()['id']);
        $payments = $billing->clientPayments((int) Auth::user()['id']);
        $this->render('client/invoices', compact('items', 'payments'));
    }

    public function profile(): void
    {
        $this->guard();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::validate($_POST['_csrf'] ?? null)) {
                http_response_code(419);
                exit('Invalid CSRF token');
            }
            $name = trim((string) ($_POST['name'] ?? ''));
            $email = trim((string) ($_POST['email'] ?? ''));
            if (!Validator::required($name) || !Validator::email($email)) {
                $_SESSION['flash_error'] = 'Profil invalide.';
                $this->redirect('/client/profile');
            }

            (new User(Database::connection($this->config)))->updateProfile((int) Auth::user()['id'], $name, $email);
            $_SESSION['user']['name'] = $name;
            $_SESSION['user']['email'] = $email;
            $_SESSION['flash_success'] = 'Profil mis à jour.';
            $this->redirect('/client/profile');
        }

        $this->render('client/profile');
    }
}
