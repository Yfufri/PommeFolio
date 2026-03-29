<?php require __DIR__ . "/../partials/layout_head.php"; ?>
<?php require __DIR__ . '/../partials/header.php'; ?>
<main class="page page-admin-competence-form">
    <section class="page-header">
        <h1><?= $mode === 'edit' ? 'Modifier un élément' : 'Ajouter un élément de culture' ?></h1>
    </section>

    <section class="form-wrapper">
        <form action="<?= $mode === 'edit' ? 'update' : 'store' ?>"
              method="post" class="form">
            <?php if ($mode === 'edit'): ?>
                <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
            <?php endif; ?>

            <div class="form-group">
                <label for="type">Type</label>
                <input type="text" id="type" name="type"
                       placeholder="ex : Lecture Personnelle, Sport, Voyage…"
                       value="<?= htmlspecialchars($item['type'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label for="titre">Titre</label>
                <input type="text" id="titre" name="titre"
                       value="<?= htmlspecialchars($item['titre'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5"><?= htmlspecialchars($item['description'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label for="date_evenement">Date</label>
                <input type="date" id="date_evenement" name="date_evenement"
                       value="<?= htmlspecialchars($item['date_evenement'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="lien">Lien (optionnel)</label>
                <input type="text" id="lien" name="lien"
                       value="<?= htmlspecialchars($item['lien'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="image">Chemin de l'image (optionnel)</label>
                <input type="text" id="image" name="image"
                       placeholder="ex : uploads/culture/photo.jpg"
                       value="<?= htmlspecialchars($item['image'] ?? '') ?>">
            </div>

            <button type="submit" class="btn btn-primary">
                <?= $mode === 'edit' ? 'Enregistrer les modifications' : 'Ajouter l\'élément' ?>
            </button>
        </form>
    </section>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
