<?php require __DIR__ . "/../partials/layout_head.php"; ?>
<?php require __DIR__ . '/../partials/header.php'; ?>
<main class="page page-admin-competence-form">
    <section class="page-header">
        <h1><?= $mode === 'edit' ? 'Modifier une compétence' : 'Ajouter une compétence' ?></h1>
    </section>

    <section class="form-wrapper">
        <form action="<?= $mode === 'edit' ? '/admin/competences/update' : '/admin/competences/store' ?>"
              method="post" class="form">
            <?php if ($mode === 'edit'): ?>
                <input type="hidden" name="id" value="<?= (int)$competence['id'] ?>">
            <?php endif; ?>

            <div class="form-group">
                <label for="annee_id">Année</label>
                <select id="annee_id" name="annee_id" required>
                    <?php foreach ($annees as $annee): ?>
                        <option value="<?= (int)$annee['id'] ?>"
                            <?= !empty($competence['annee_id']) && $competence['annee_id'] == $annee['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($annee['label']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="code">Code (ex : C1)</label>
                <input type="text" id="code" name="code"
                       value="<?= htmlspecialchars($competence['code'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label for="titre">Titre</label>
                <input type="text" id="titre" name="titre"
                       value="<?= htmlspecialchars($competence['titre'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5"><?= htmlspecialchars($competence['description'] ?? '') ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                <?= $mode === 'edit' ? 'Enregistrer les modifications' : 'Créer la compétence' ?>
            </button>
        </form>
    </section>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
