<?php

declare(strict_types=1);

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\ClientController;
use App\Controllers\PublicController;
use App\Core\Router;
use App\Core\Session;

require __DIR__ . '/../app/bootstrap.php';

$config = require __DIR__ . '/../config/config.php';
Session::start($config);

$router = new Router();

$public = new PublicController($config);
$auth = new AuthController($config);
$client = new ClientController($config);
$admin = new AdminController($config);

$router->get('/', [$public, 'home']);
$router->get('/offers', [$public, 'offers']);
$router->get('/pricing', [$public, 'pricing']);
$router->get('/faq', [$public, 'faq']);
$router->get('/contact', [$public, 'contact']);
$router->get('/game', [$public, 'game']);

$router->get('/login', [$auth, 'showLogin']);
$router->post('/login', [$auth, 'login']);
$router->get('/register', [$auth, 'showRegister']);
$router->post('/register', [$auth, 'register']);
$router->get('/forgot-password', [$auth, 'forgotPassword']);
$router->get('/logout', [$auth, 'logout']);

$router->get('/client', [$client, 'dashboard']);
$router->get('/client/invoices', [$client, 'invoices']);
$router->get('/client/profile', [$client, 'profile']);
$router->post('/client/profile', [$client, 'profile']);

$router->get('/admin', [$admin, 'dashboard']);
$router->get('/admin/customers', [$admin, 'customers']);
$router->get('/admin/products', [$admin, 'products']);
$router->post('/admin/products', [$admin, 'products']);
$router->get('/admin/offers', [$admin, 'offers']);
$router->post('/admin/offers', [$admin, 'offers']);
$router->get('/admin/services', [$admin, 'services']);
$router->get('/admin/orders', [$admin, 'orders']);
$router->get('/admin/invoices', [$admin, 'invoices']);
$router->get('/admin/integrations', [$admin, 'integrations']);
$router->post('/admin/integrations', [$admin, 'integrations']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
