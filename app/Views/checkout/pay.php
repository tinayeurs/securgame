<h1>Payer la facture</h1>
<div class="card">
<p>Facture: <?= htmlspecialchars($invoice['invoice_number']) ?></p>
<p>Montant: <strong><?= number_format((float) $invoice['amount'], 2) ?>€</strong></p>
<p>Statut: <?= htmlspecialchars($invoice['status']) ?></p>
</div>
<form method="post" action="/checkout/pay" class="card">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken) ?>">
    <input type="hidden" name="invoice_id" value="<?= (int) $invoice['id'] ?>">
    <label>Moyen de paiement</label>
    <select name="method"><option value="stripe_test">Stripe (test)</option><option value="card_manual">Carte (simulation)</option></select>
    <button class="btn" type="submit">Confirmer le paiement</button>
</form>
