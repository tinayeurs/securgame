<h1>Jeux</h1>
<form method="post" class="card">
<input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken) ?>">
<label>Nom</label><input name="name" required>
<label>Slug</label><input name="slug" required>
<label>Description</label><textarea name="description"></textarea>
<button class="btn" type="submit">Ajouter</button>
</form>
<table class="table"><tr><th>Nom</th><th>Slug</th><th>Statut</th></tr><?php foreach($games as $g): ?><tr><td><?= htmlspecialchars($g['name']) ?></td><td><?= htmlspecialchars($g['slug']) ?></td><td><?= (int)$g['is_active'] ? 'Actif' : 'Inactif' ?></td></tr><?php endforeach; ?></table>
