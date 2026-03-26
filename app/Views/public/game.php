<h1>Offres pour <?= htmlspecialchars((string)$slug) ?></h1>
<?php if (!$offers): ?><p class="card">Aucune offre active pour ce jeu.</p><?php endif; ?>
<?php foreach($offers as $o): ?><div class="card"><h3><?= htmlspecialchars($o['name']) ?></h3><p><?= htmlspecialchars($o['description']) ?></p><p><?= number_format((float)$o['price_monthly'],2) ?> € / mois</p></div><?php endforeach; ?>
