<h1>Intégrations externes</h1>
<form method="post" class="card">
<input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken) ?>">
<label>Mode</label><select name="mode"><option value="test">test</option><option value="production">production</option></select>
<h3>Pterodactyl</h3>
<label>Nom du panel</label><input name="panel_name" value="<?= htmlspecialchars($integrationSettings['pterodactyl']['panel_name']['config_value'] ?? '') ?>">
<label>URL panel</label><input name="panel_url" value="<?= htmlspecialchars($integrationSettings['pterodactyl']['panel_url']['config_value'] ?? '') ?>">
<label>API key</label><input name="api_key" value="<?= htmlspecialchars($integrationSettings['pterodactyl']['api_key']['config_value'] ?? '') ?>">
<h3>Stripe</h3>
<label>Public key</label><input name="stripe_public" value="<?= htmlspecialchars($integrationSettings['stripe']['public_key']['config_value'] ?? '') ?>">
<label>Secret key</label><input name="stripe_secret" value="<?= htmlspecialchars($integrationSettings['stripe']['secret_key']['config_value'] ?? '') ?>">
<label>Webhook secret</label><input name="stripe_webhook" value="<?= htmlspecialchars($integrationSettings['stripe']['webhook_secret']['config_value'] ?? '') ?>">
<button class="btn" type="submit">Sauvegarder</button>
</form>
<div class="card"><p>États attendus: non_configuré, connecté, erreur, en_cours.</p></div>
