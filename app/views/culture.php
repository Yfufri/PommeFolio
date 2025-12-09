<?php require __DIR__ . '/partials/header.php'; ?>
<main class="page page-culture">
    <section class="page-header">
        <h1>Culture générale</h1>
        <p>
            Voyages, lectures, permis moto et d’autres expériences qui complètent mon profil
            d’étudiant en BUT Informatique.
        </p>
    </section>

    <section class="culture-grid">
        <?php foreach ($itemsCulture as $item): ?>
            <article class="culture-card">
                <div class="culture-tag"><?= htmlspecialchars($item['type']) ?></div>
                <h2><?= htmlspecialchars($item['titre']) ?></h2>
                <?php if (!empty($item['date'])): ?>
                    <p class="culture-date"><?= htmlspecialchars($item['date']) ?></p>
                <?php endif; ?>
                <p class="culture-description">
                    <?= nl2br(htmlspecialchars($item['description'])) ?>
                </p>

                <?php if (!empty($item['lien'])): ?>
                    <a href="<?= htmlspecialchars($item['lien']) ?>" target="_blank" class="card-link">
                        En savoir plus →
                    </a>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </section>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>
