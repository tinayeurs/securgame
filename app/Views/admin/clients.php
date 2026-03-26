<h1>Clients</h1>
<table class="table"><tr><th>ID</th><th>Nom</th><th>Email</th><th>Statut</th><th>Créé le</th></tr><?php foreach($clients as $c): ?><tr><td><?= (int)$c['id'] ?></td><td><?= htmlspecialchars($c['name']) ?></td><td><?= htmlspecialchars($c['email']) ?></td><td><?= htmlspecialchars($c['status']) ?></td><td><?= htmlspecialchars($c['created_at']) ?></td></tr><?php endforeach; ?></table>
