<h1>Factures & paiements</h1>
<h3>Factures</h3>
<table class="table"><tr><th>Numéro</th><th>Montant</th><th>Statut</th><th>Action</th></tr><?php foreach($items as $inv): ?><tr><td><?= htmlspecialchars($inv['invoice_number']) ?></td><td><?= number_format((float)$inv['amount'],2) ?>€</td><td><?= htmlspecialchars($inv['status']) ?></td><td><?php if($inv['status'] !== 'paid'): ?><a class="btn" href="/checkout/pay?invoice_id=<?= (int)$inv['id'] ?>">Payer</a><?php endif; ?></td></tr><?php endforeach; ?></table>
<h3>Paiements</h3>
<table class="table"><tr><th>Référence</th><th>Méthode</th><th>Montant</th><th>Statut</th></tr><?php foreach($payments as $p): ?><tr><td><?= htmlspecialchars($p['transaction_reference']) ?></td><td><?= htmlspecialchars($p['method']) ?></td><td><?= number_format((float)$p['amount'],2) ?>€</td><td><?= htmlspecialchars($p['status']) ?></td></tr><?php endforeach; ?></table>
