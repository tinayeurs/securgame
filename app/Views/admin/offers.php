<h1>Offres</h1>
<form method="post" class="card">
<input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken) ?>">
<label>Produit</label><select name="product_id"><?php foreach($products as $p): ?><option value="<?= (int)$p['id'] ?>"><?= htmlspecialchars($p['game_name'] . ' / ' . $p['name']) ?></option><?php endforeach; ?></select>
<label>Nom</label><input name="name" required>
<label>Description</label><textarea name="description"></textarea>
<label>Prix mensuel</label><input type="number" step="0.01" name="price_monthly" required>
<label>Frais setup</label><input type="number" step="0.01" name="setup_fee" value="0">
<label>RAM MB</label><input type="number" name="ram_mb" required>
<label>CPU</label><input type="number" name="cpu_cores" required>
<label>Stockage GB</label><input type="number" name="storage_gb" required>
<label>Slots</label><input type="number" name="slots" value="20">
<label>Statut</label><select name="status"><option value="active">active</option><option value="inactive">inactive</option></select>
<label>Pterodactyl egg/nest/location</label>
<div class="grid grid-3"><input type="number" name="ptero_egg_id" placeholder="egg"><input type="number" name="ptero_nest_id" placeholder="nest"><input type="number" name="ptero_location_id" placeholder="location"></div>
<label><input type="checkbox" name="is_active" checked> Actif</label>
<button class="btn" type="submit">Ajouter offre</button>
</form>
<table class="table"><tr><th>Jeu</th><th>Produit</th><th>Offre</th><th>Prix</th><th>Ressources</th><th>Statut</th></tr><?php foreach($offers as $o): ?><tr><td><?= htmlspecialchars($o['game_name']) ?></td><td><?= htmlspecialchars($o['product_name']) ?></td><td><?= htmlspecialchars($o['name']) ?></td><td><?= number_format((float)$o['price_monthly'],2) ?>€</td><td><?= (int)$o['ram_mb'] ?>MB/<?= (int)$o['cpu_cores'] ?>CPU/<?= (int)$o['storage_gb'] ?>GB</td><td><?= htmlspecialchars($o['status']) ?></td></tr><?php endforeach; ?></table>
