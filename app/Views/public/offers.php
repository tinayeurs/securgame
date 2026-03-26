<h1>Catalogue des offres</h1>
<div class="grid grid-3">
<?php foreach ($offers as $offer): ?>
    <div class="card">
        <h3><?= htmlspecialchars($offer['name']) ?></h3>
        <p><?= htmlspecialchars($offer['game_name']) ?> / <?= htmlspecialchars($offer['product_name']) ?></p>
        <p><?= (int) $offer['ram_mb'] ?>MB RAM • <?= (int) $offer['cpu_cores'] ?> vCPU • <?= (int) $offer['storage_gb'] ?>GB</p>
        <p><strong><?= number_format((float) $offer['price_monthly'], 2) ?>€ / mois</strong></p>
        <a class="btn" href="/checkout/configure?offer_id=<?= (int) $offer['id'] ?>">Commander</a>
    </div>
<?php endforeach; ?>
</div>
