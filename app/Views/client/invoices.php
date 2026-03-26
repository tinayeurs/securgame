<h1>Factures & Paiements</h1>
<h3>Factures</h3>
<table class="table"><tr><th>Numéro</th><th>Montant</th><th>Statut</th><th>Échéance</th></tr><?php foreach($items as $i): ?><tr><td><?= htmlspecialchars($i['invoice_number']) ?></td><td><?= number_format((float)$i['amount'],2) ?>€</td><td><?= htmlspecialchars($i['status']) ?></td><td><?= htmlspecialchars((string)$i['due_date']) ?></td></tr><?php endforeach; ?></table>
<h3>Paiements</h3>
<table class="table"><tr><th>Référence</th><th>Montant</th><th>Méthode</th><th>Statut</th></tr><?php foreach($payments as $p): ?><tr><td><?= htmlspecialchars($p['transaction_reference']) ?></td><td><?= number_format((float)$p['amount'],2) ?>€</td><td><?= htmlspecialchars($p['method']) ?></td><td><?= htmlspecialchars($p['status']) ?></td></tr><?php endforeach; ?></table>
