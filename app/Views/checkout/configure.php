<h1>Configurer votre service</h1>
<div class="card">
    <h3><?= htmlspecialchars($offer['name']) ?></h3>
    <p><?= htmlspecialchars($offer['game_name']) ?> - <?= htmlspecialchars($offer['product_name']) ?></p>
    <p><?= (int) $offer['ram_mb'] ?>MB RAM / <?= (int) $offer['cpu_cores'] ?> vCPU / <?= (int) $offer['storage_gb'] ?> GB</p>
    <p><strong><?= number_format((float) $offer['price_monthly'], 2) ?>€ / mois</strong></p>
</div>
<form method="post" action="/checkout/place-order" class="card">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken) ?>">
    <input type="hidden" name="offer_id" value="<?= (int) $offer['id'] ?>">
    <label>Nom du serveur</label>
    <input name="server_name" value="Mon serveur <?= htmlspecialchars($offer['game_name']) ?>">
    <button class="btn" type="submit">Valider et générer facture</button>
</form>
