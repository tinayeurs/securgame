<h1>Comparatif des plans</h1>
<table class="table">
<tr><th>Jeu</th><th>Produit</th><th>Offre</th><th>Ressources</th><th>Prix mensuel</th></tr>
<?php foreach ($offers as $offer): ?>
<tr>
<td><?= htmlspecialchars($offer['game_name']) ?></td>
<td><?= htmlspecialchars($offer['product_name']) ?></td>
<td><?= htmlspecialchars($offer['name']) ?></td>
<td><?= (int) $offer['ram_mb'] ?>MB / <?= (int) $offer['cpu_cores'] ?>CPU / <?= (int) $offer['storage_gb'] ?>GB</td>
<td><?= number_format((float) $offer['price_monthly'], 2) ?>€</td>
</tr>
<?php endforeach; ?>
</table>
