<h1>Connexion client</h1>
<form class="card" method="post" action="/login">
<input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken) ?>">
<label>Email</label><input type="email" name="email" required>
<label>Mot de passe</label><input type="password" name="password" required>
<button class="btn" type="submit">Se connecter</button>
</form>
