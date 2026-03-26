<h1>Détail du service #<?= (int) $service['id'] ?></h1>
<div class="grid grid-2">
<div class="card">
<h3>Informations serveur</h3>
<p>Jeu: <?= htmlspecialchars($service['game_name']) ?></p>
<p>Produit: <?= htmlspecialchars($service['product_name']) ?></p>
<p>Offre: <?= htmlspecialchars($service['offer_name']) ?></p>
<p>Statut: <?= htmlspecialchars($service['status']) ?></p>
<p>Provisioning: <?= htmlspecialchars($service['provisioning_status']) ?></p>
<p>CPU: <?= (int) $service['cpu_cores'] ?> vCPU</p>
<p>RAM: <?= (int) $service['ram_mb'] ?> MB</p>
<p>Stockage: <?= (int) $service['storage_gb'] ?> GB</p>
<p>Slots: <?= (int) $service['slots'] ?></p>
<p>Date création: <?= htmlspecialchars($service['created_at']) ?></p>
<p>Date expiration: <?= htmlspecialchars((string) $service['expires_at']) ?></p>
</div>
<div class="card">
<h3>Zone panel (préparée)</h3>
<ul>
<li>Console (placeholder)</li>
<li>Fichiers (placeholder)</li>
<li>Sauvegardes (placeholder)</li>
<li>Ressources live (placeholder)</li>
</ul>
</div>
</div>
<h3>Logs de provisioning</h3>
<table class="table"><tr><th>Date</th><th>Statut</th><th>Message</th></tr><?php foreach($logs as $log): ?><tr><td><?= htmlspecialchars($log['created_at']) ?></td><td><?= htmlspecialchars($log['status']) ?></td><td><?= htmlspecialchars($log['message']) ?></td></tr><?php endforeach; ?></table>
