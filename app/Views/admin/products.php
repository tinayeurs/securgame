<h1>Produits</h1>
<form method="post" class="card">
<input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken) ?>">
<label>Jeu</label><select name="game_id"><?php foreach($games as $g): ?><option value="<?= (int)$g['id'] ?>"><?= htmlspecialchars($g['name']) ?></option><?php endforeach; ?></select>
<label>Nom</label><input name="name" required>
<label>Slug</label><input name="slug" required>
<label>Description</label><textarea name="description"></textarea>
<label>Ordre</label><input type="number" name="sort_order" value="0">
<label><input type="checkbox" name="is_active" checked> Actif</label>
<button class="btn" type="submit">Ajouter</button>
</form>
<table class="table"><tr><th>Jeu</th><th>Produit</th><th>Slug</th><th>Actif</th></tr><?php foreach($products as $p): ?><tr><td><?= htmlspecialchars($p['game_name']) ?></td><td><?= htmlspecialchars($p['name']) ?></td><td><?= htmlspecialchars($p['slug']) ?></td><td><?= (int)$p['is_active'] ? 'Oui' : 'Non' ?></td></tr><?php endforeach; ?></table>
