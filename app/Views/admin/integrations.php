<h1>Intégrations externes</h1>
<div class="card"><p>Statut Pterodactyl et Stripe configurable en mode test/production.</p></div>
<form method="post" class="card"><input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken) ?>">
<label>Mode</label><select name="mode"><option value="test">test</option><option value="production">production</option></select>
<label>Pterodactyl URL</label><input name="pterodactyl_url" value="<?= htmlspecialchars($integrations['pterodactyl'][0]['config_value'] ?? '') ?>">
<label>Pterodactyl API Key</label><input name="pterodactyl_api_key" value="<?= htmlspecialchars($integrations['pterodactyl'][1]['config_value'] ?? '') ?>">
<label>Stripe Public Key</label><input name="stripe_public_key" value="<?= htmlspecialchars($integrations['stripe'][0]['config_value'] ?? '') ?>">
<label>Stripe Secret Key</label><input name="stripe_secret_key" value="<?= htmlspecialchars($integrations['stripe'][1]['config_value'] ?? '') ?>">
<button class="btn" type="submit">Sauvegarder</button>
</form>
