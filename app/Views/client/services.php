<h1>Mes services</h1>
<table class="table">
<tr><th>ID</th><th>Jeu</th><th>Offre</th><th>Statut</th><th>Provisioning</th><th>Expiration</th><th></th></tr>
<?php foreach ($services as $service): ?>
<tr>
<td><?= (int) $service['id'] ?></td>
<td><?= htmlspecialchars($service['game_name']) ?></td>
<td><?= htmlspecialchars($service['offer_name']) ?></td>
<td><span class="badge"><?= htmlspecialchars($service['status']) ?></span></td>
<td><?= htmlspecialchars($service['provisioning_status']) ?></td>
<td><?= htmlspecialchars((string) $service['expires_at']) ?></td>
<td><a href="/client/service?id=<?= (int) $service['id'] ?>">Détails</a></td>
</tr>
<?php endforeach; ?>
</table>
