<section class="hero card">
    <h1>SecurGame - Plateforme SaaS d'hébergement de serveurs de jeux</h1>
    <p>Commandez, payez, provisionnez et gérez vos serveurs depuis un espace client professionnel.</p>
    <a class="btn" href="/offers">Commander maintenant</a>
</section>

<section>
    <h2>Jeux disponibles</h2>
    <div class="grid grid-3">
        <?php foreach ($games as $game): ?>
            <article class="card">
                <h3><?= htmlspecialchars($game['name']) ?></h3>
                <p><?= htmlspecialchars((string) $game['description']) ?></p>
                <a href="/game?slug=<?= urlencode($game['slug']) ?>">Voir les offres</a>
            </article>
        <?php endforeach; ?>
    </div>
</section>
