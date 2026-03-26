<h1>Connexion administrateur</h1>
<p class="card">Accès réservé au panel d'administration SecurGame.</p>
<form class="card" method="post" action="/admin/login">
<input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken) ?>">
<label>Email admin</label><input type="email" name="email" required>
<label>Mot de passe</label><input type="password" name="password" required>
<button class="btn" type="submit">Entrer dans l'admin</button>
</form>
