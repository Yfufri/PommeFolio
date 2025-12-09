<?php require __DIR__ . '/../partials/header.php'; ?>
<main class="page page-admin-ac-form">
    <section class="page-header">
        <h1><?= $mode === 'edit' ? 'Modifier une AC' : 'Ajouter une AC' ?></h1>
        <p>Compétence : <?= htmlspecialchars($competence['code']) ?> – <?= htmlspecialchars($competence['titre']) ?></p>
    </section>

    <section class="form-wrapper">
        <form action="<?= $mode === 'edit' ? '/admin/acs/update' : '/admin/acs/store' ?>"
              method="post" class="form">
            <?php if ($mode === 'edit'): ?>
                <input type="hidden" name="id" value="<?= (int)$ac['id'] ?>">
            <?php endif; ?>

            <input type="hidden" name="competence_id" value="<?= (int)$competence['id'] ?>">

            <div class="form-group">
                <label for="code">Code (ex : AC1)</label>
                <input type="text" id="code" name="code"
                       value="<?= htmlspecialchars($ac['code'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label for="titre">Titre</label>
                <input type="text" id="titre" name="titre"
                       value="<?= htmlspecialchars($ac['titre'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description (ce que tu sais faire)</label>
                <textarea id="description" name="description" rows="5"><?= htmlspecialchars($ac['description'] ?? '') ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                <?= $mode === 'edit' ? 'Enregistrer' : 'Créer l’AC' ?>
            </button>
        </form>
    </section>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
