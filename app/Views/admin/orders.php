<h1>Commandes</h1>
<table class="table"><tr><th>ID</th><th>Client</th><th>Total</th><th>Statut</th></tr><?php foreach($items as $o): ?><tr><td><?= (int)$o['id'] ?></td><td><?= htmlspecialchars($o['email']) ?></td><td><?= number_format((float)$o['total_amount'],2) ?>€</td><td><?= htmlspecialchars($o['status']) ?></td></tr><?php endforeach; ?></table>
