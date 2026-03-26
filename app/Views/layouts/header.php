<?php use App\Core\Auth; ?>
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
        <a class="brand" href="/">SecurGame</a>
        <div class="nav-links">
            <a href="/offers">Offres</a><a href="/pricing">Tarifs</a><a href="/faq">FAQ</a><a href="/contact">Contact</a>
            <?php if (Auth::check()): ?>
                <a href="<?= Auth::isAdmin() ? '/admin' : '/client' ?>">Dashboard</a>
                <a href="/logout">Déconnexion</a>
            <?php else: ?>
                <a href="/login">Connexion</a><a href="/register">Inscription</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<main class="container">
    <?php if (!empty($_SESSION['flash_success'])): ?><div class="flash ok"><?php echo htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?></div><?php endif; ?>
    <?php if (!empty($_SESSION['flash_error'])): ?><div class="flash err"><?php echo htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?></div><?php endif; ?>
