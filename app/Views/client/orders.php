<h1>Mes commandes</h1>
<table class="table"><tr><th>ID</th><th>Total</th><th>Statut</th><th>Date</th></tr><?php foreach($orders as $order): ?><tr><td>#<?= (int)$order['id'] ?></td><td><?= number_format((float)$order['total_amount'],2) ?>€</td><td><?= htmlspecialchars($order['status']) ?></td><td><?= htmlspecialchars($order['created_at']) ?></td></tr><?php endforeach; ?></table>
