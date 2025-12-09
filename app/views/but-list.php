<?php require __DIR__ . '/partials/layout_head.php'; ?>
<?php require __DIR__ . '/partials/header.php'; ?>

<main class="page page-but-explorer">
    <section class="page-header">
        <h1>Parcours BUT Informatique</h1>
        <p>
            Explore mes années, compétences et acquis d’apprentissage (AC) via cette vue interactive.
        </p>
    </section>

    <section id="but-explorer"
             class="but-explorer"
             data-annees='<?= json_encode($annees, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>'
             data-acs='<?= json_encode($acsParCompetence, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>'>
        <!-- VueJS montera ici et remplacera ce contenu -->
        <p>Chargement de l’explorateur...</p>
    </section>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
