<h1>Dashboard client</h1>
<div class="grid grid-4">
<div class="card"><h3>Services</h3><p><?= count($services) ?></p></div>
<div class="card"><h3>Commandes</h3><p><?= count($orders) ?></p></div>
<div class="card"><h3>Factures</h3><p><?= count($invoices) ?></p></div>
<div class="card"><h3>Paiements</h3><p><?= count($payments) ?></p></div>
</div>
<div class="card"><a class="btn" href="/client/services">Gérer mes services</a> <a class="btn" href="/client/orders">Voir mes commandes</a></div>
