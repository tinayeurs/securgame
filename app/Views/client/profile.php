<h1>Profil client</h1>
<form method="post" class="card" action="/client/profile">
<input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken) ?>">
<label>Nom</label><input name="name" value="<?= htmlspecialchars($clientUser['name']) ?>" required>
<label>Email</label><input type="email" name="email" value="<?= htmlspecialchars($clientUser['email']) ?>" required>
<button class="btn" type="submit">Sauvegarder</button>
</form>
