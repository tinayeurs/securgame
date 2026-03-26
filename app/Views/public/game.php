<h1><?= htmlspecialchars($game['name'] ?? 'Jeu') ?></h1>
<p>Plans disponibles pour ce jeu.</p>
<div class="grid grid-3">
<?php foreach ($offers as $offer): ?>
    <article class="card">
        <h3><?= htmlspecialchars($offer['name']) ?></h3>
        <p><?= number_format((float) $offer['price_monthly'], 2) ?>€/mois</p>
        <a class="btn" href="/checkout/configure?offer_id=<?= (int) $offer['id'] ?>">Choisir</a>
    </article>
<?php endforeach; ?>
</div>
