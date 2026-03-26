<h1>Facturation admin</h1>
<h3>Factures</h3>
<table class="table"><tr><th>#</th><th>Client</th><th>Montant</th><th>Statut</th><th>Échéance</th></tr><?php foreach($invoices as $i): ?><tr><td><?= htmlspecialchars($i['invoice_number']) ?></td><td><?= htmlspecialchars($i['email']) ?></td><td><?= number_format((float)$i['amount'],2) ?>€</td><td><?= htmlspecialchars($i['status']) ?></td><td><?= htmlspecialchars((string)$i['due_date']) ?></td></tr><?php endforeach; ?></table>
<h3>Paiements</h3>
<table class="table"><tr><th>Référence</th><th>Client</th><th>Montant</th><th>Méthode</th><th>Statut</th></tr><?php foreach($payments as $p): ?><tr><td><?= htmlspecialchars($p['transaction_reference']) ?></td><td><?= htmlspecialchars($p['email']) ?></td><td><?= number_format((float)$p['amount'],2) ?>€</td><td><?= htmlspecialchars($p['method']) ?></td><td><?= htmlspecialchars($p['status']) ?></td></tr><?php endforeach; ?></table>
