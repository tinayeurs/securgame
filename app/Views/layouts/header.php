<?php
$isAdminArea = str_starts_with(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/', '/admin');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecurGame</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<nav class="navbar">
    <div class="container nav-flex">
        <a class="brand" href="<?= $isAdminArea ? '/admin' : '/' ?>">SecurGame</a>
        <?php if ($isAdminArea): ?>
            <div class="nav-links">
                <?php if (!empty($adminUser)): ?>
                    <a href="/admin">Dashboard</a><a href="/admin/clients">Clients</a><a href="/admin/admins">Admins</a><a href="/admin/games">Jeux</a><a href="/admin/products">Produits</a><a href="/admin/offers">Offres</a><a href="/admin/orders">Commandes</a><a href="/admin/services">Services</a><a href="/admin/billing">Facturation</a><a href="/admin/integrations">Intégrations</a><a href="/admin/logout">Déconnexion admin</a>
                <?php else: ?>
                    <a href="/admin/login">Connexion admin</a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="nav-links">
                <a href="/offers">Offres</a><a href="/pricing">Comparatif</a><a href="/faq">FAQ</a><a href="/contact">Contact</a>
                <?php if (!empty($clientUser)): ?>
                    <a href="/client">Espace client</a><a href="/logout">Déconnexion</a>
                <?php else: ?>
                    <a href="/login">Connexion client</a><a href="/register">Inscription</a><a href="/admin/login">Admin</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</nav>
<main class="container">
<?php if (!empty($_SESSION['flash_success'])): ?><div class="flash ok"><?= htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?></div><?php endif; ?>
<?php if (!empty($_SESSION['flash_error'])): ?><div class="flash err"><?= htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?></div><?php endif; ?>
