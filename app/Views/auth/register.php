<h1>Créer un compte client</h1>
<form class="card" method="post" action="/register">
<input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken) ?>">
<label>Nom</label><input name="name" required>
<label>Email</label><input type="email" name="email" required>
<label>Mot de passe</label><input type="password" name="password" required>
<button class="btn" type="submit">Créer mon compte</button>
</form>
