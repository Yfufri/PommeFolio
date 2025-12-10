<?php require __DIR__ . "/partials/layout_head.php"; ?>
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
            <div class="culture-card">
                <?php if (!empty($item['image'])): ?>
                    <img src="<?= htmlspecialchars($item['image']) ?>" alt="" class="culture-image">
                <?php endif; ?>

                <div class="culture-content">
                    <div class="culture-tag"><?= htmlspecialchars($item['type']) ?></div>
                    <h3><?= htmlspecialchars($item['titre']) ?></h3>
                    <p class="culture-date"><?= htmlspecialchars($item['date_evenement']) ?></p>
                    <p><?= nl2br(htmlspecialchars($item['description'])) ?></p>

                    <?php if (!empty($item['lien'])): ?>
                        <a href="<?= htmlspecialchars($item['lien']) ?>" class="culture-link" target="_blank">
                            Voir plus →
                        </a>
                    <?php endif; ?>
                </div>
            </div>

        <?php endforeach; ?>
    </section>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>
