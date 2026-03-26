<?php

declare(strict_types=1);

use App\Controllers\AdminAuthController;
use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\CheckoutController;
use App\Controllers\ClientController;
use App\Controllers\PublicController;
use App\Core\Router;
use App\Core\Session;

require __DIR__ . '/../app/bootstrap.php';

$config = require __DIR__ . '/../config/config.php';
Session::start($config);

date_default_timezone_set($config['app']['timezone'] ?? 'UTC');

$router = new Router();

$public = new PublicController($config);
$auth = new AuthController($config);
$adminAuth = new AdminAuthController($config);
$client = new ClientController($config);
$admin = new AdminController($config);
$checkout = new CheckoutController($config);

// Public
$router->get('/', [$public, 'home']);
$router->get('/offers', [$public, 'offers']);
$router->get('/pricing', [$public, 'pricing']);
$router->get('/faq', [$public, 'faq']);
$router->get('/contact', [$public, 'contact']);
$router->get('/game', [$public, 'game']);

// Client auth
$router->get('/login', [$auth, 'loginForm']);
$router->post('/login', [$auth, 'login']);
$router->get('/register', [$auth, 'registerForm']);
$router->post('/register', [$auth, 'register']);
$router->get('/logout', [$auth, 'logout']);

// Admin auth (séparée)
$router->get('/admin/login', [$adminAuth, 'loginForm']);
$router->post('/admin/login', [$adminAuth, 'login']);
$router->get('/admin/logout', [$adminAuth, 'logout']);

// Checkout flow
$router->get('/checkout/configure', [$checkout, 'configure']);
$router->post('/checkout/place-order', [$checkout, 'placeOrder']);
$router->get('/checkout/pay', [$checkout, 'paymentPage']);
$router->post('/checkout/pay', [$checkout, 'pay']);

// Client area
$router->get('/client', [$client, 'dashboard']);
$router->get('/client/services', [$client, 'services']);
$router->get('/client/service', [$client, 'serviceDetail']);
$router->get('/client/orders', [$client, 'orders']);
$router->get('/client/invoices', [$client, 'invoices']);
$router->get('/client/profile', [$client, 'profile']);
$router->post('/client/profile', [$client, 'profile']);

// Admin area
$router->get('/admin', [$admin, 'dashboard']);
$router->get('/admin/clients', [$admin, 'clients']);
$router->get('/admin/admins', [$admin, 'admins']);
$router->get('/admin/games', [$admin, 'games']);
$router->post('/admin/games', [$admin, 'games']);
$router->get('/admin/products', [$admin, 'products']);
$router->post('/admin/products', [$admin, 'products']);
$router->get('/admin/offers', [$admin, 'offers']);
$router->post('/admin/offers', [$admin, 'offers']);
$router->get('/admin/orders', [$admin, 'orders']);
$router->get('/admin/services', [$admin, 'services']);
$router->get('/admin/billing', [$admin, 'billing']);
$router->get('/admin/integrations', [$admin, 'integrations']);
$router->post('/admin/integrations', [$admin, 'integrations']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
