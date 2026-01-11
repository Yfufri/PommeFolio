<?php require __DIR__ . "/partials/layout_head.php"; ?>
<?php require __DIR__ . '/partials/header.php'; ?>
<main class="page page-but">
    <section class="breadcrumb">
        <a href="/pommefolio/home">Accueil</a>
        <span>›</span>
        <a href="/pommefolio/but">BUT Informatique</a>
        <?php if (!empty($annee)): ?>
            <span>›</span><span><?= htmlspecialchars($annee['label']) ?></span>
        <?php endif; ?>
        <?php if (!empty($competence)): ?>
            <span>›</span><span><?= htmlspecialchars($competence['code']) ?></span>
        <?php endif; ?>
    </section>

    <a href="../but" class="btn btn-secondary">Retour</a>

    <?php if (!empty($competence)): ?>
        <section class="competence-header">
            <h1>
                <?= htmlspecialchars($competence['code']) ?> –
                <?= htmlspecialchars($competence['titre']) ?>
            </h1>
            <p class="competence-description">
                <?= nl2br(htmlspecialchars($competence['description'])) ?>
            </p>

            <?php if (!empty($illustrationsGlobales)): ?>
                <div class="competence-illustrations-globales">
                    <?php foreach ($illustrationsGlobales as $illu): ?>
                        <div class="illu-card">
                            <h3><?= htmlspecialchars($illu['titre'] ?? 'Illustration') ?></h3>
                            <?php if ($illu['type'] === 'image'): ?>
                                <img src="../public/<?= htmlspecialchars($illu['path']) ?>" alt="<?= htmlspecialchars($illu['titre'] ?? '') ?>">
                            <?php elseif ($illu['type'] === 'pdf'): ?>
                                <div class="pdf-container">
                                <iframe
                                        src="../public/<?= htmlspecialchars($illu['path']) ?>#toolbar=0"
                                        type="application/pdf"
                                        class="illu-pdf"
                                        width="100%"
                                        height="500px">
                                </iframe>
                                <div class="pdf-fallback">
                                    <a href="../public/<?= htmlspecialchars($illu['path']) ?>" target="_blank" class="btn btn-link">
                                        Ouvrir le PDF dans un nouvel onglet (Plein écran) →
                                    </a>
                                </div>
                                </div>
                            <?php elseif ($illu['type'] === 'video'): ?>
                                <video controls class="illu-video">
                                    <source src="/<?= htmlspecialchars($illu['path']) ?>">
                                </video>
                            <?php elseif ($illu['type'] === 'url'): ?>
                                <a href="<?= htmlspecialchars($illu['path']) ?>" target="_blank" class="btn btn-link">
                                    Ouvrir l’illustration
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    <?php endif; ?>

    <section class="acs-section">
        <h2>Acquis d’apprentissage (AC)</h2>
        <div class="acs-grid">
            <?php foreach ($acs as $ac): ?>
                <article class="ac-card">
                    <div class="ac-header">
                        <span class="ac-code"><?= htmlspecialchars($ac['code']) ?></span>
                        <h3><?= htmlspecialchars($ac['titre']) ?></h3>
                    </div>
                    <p class="ac-description">
                        <?= nl2br(htmlspecialchars($ac['description'])) ?>
                    </p>

                    <?php if (!empty($illustrationsParAc[$ac['id']] ?? [])): ?>
                        <div class="ac-illustrations">
                            <?php foreach ($illustrationsParAc[$ac['id']] as $illu): ?>
                                <div class="illu-wrapper">
                                    <h4 class="illu-title"><?= htmlspecialchars($illu['titre'] ?? 'Illustration') ?></h4>

                                    <div class="illu-thumb">
                                        <?php if ($illu['type'] === 'image'): ?>
                                            <img src="../public/<?= htmlspecialchars($illu['path']) ?>" alt="<?= htmlspecialchars($illu['titre'] ?? '') ?>">
                                        <?php elseif ($illu['type'] === 'pdf'): ?>
                                            <a href="/pommefolio/<?= htmlspecialchars($illu['path']) ?>" target="_blank" class="illu-link">
                                                Voir le PDF
                                            </a>
                                        <?php elseif ($illu['type'] === 'video'): ?>
                                            <video controls class="illu-video">
                                                <source src="/pommefolio/<?= htmlspecialchars($illu['path']) ?>">
                                            </video>
                                        <?php elseif ($illu['type'] === 'url'): ?>
                                            <a href="<?= htmlspecialchars($illu['path']) ?>" target="_blank" class="illu-link">
                                                Lien externe
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>
