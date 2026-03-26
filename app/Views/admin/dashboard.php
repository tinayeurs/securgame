<h1>Panel administrateur</h1>
<div class="grid grid-4">
<?php foreach($stats as $label => $value): ?><div class="card"><h3><?= htmlspecialchars(ucfirst($label)) ?></h3><p><?= (int)$value ?></p></div><?php endforeach; ?>
</div>
<div class="card">
<p>Centre de pilotage de la plateforme: commandes, facturation, provisioning, intégrations.</p>
</div>
