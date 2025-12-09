<?php require __DIR__ . '/../partials/header.php'; ?>
<main class="page page-admin-competences">
    <section class="page-header">
        <h1>Compétences BUT</h1>
        <a href="/admin/competences/create" class="btn btn-primary">Ajouter une compétence</a>
    </section>

    <section class="table-wrapper">
        <table class="table">
            <thead>
            <tr>
                <th>Année</th>
                <th>Code</th>
                <th>Titre</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($competences as $comp): ?>
                <tr class="table-row-hover">
                    <td><?= htmlspecialchars($comp['annee_label']) ?></td>
                    <td><?= htmlspecialchars($comp['code']) ?></td>
                    <td><?= htmlspecialchars($comp['titre']) ?></td>
                    <td class="table-actions">
                        <a href="/admin/competences/edit?id=<?= (int)$comp['id'] ?>" class="btn btn-small">Modifier</a>
                        <a href="/admin/competences/delete?id=<?= (int)$comp['id'] ?>"
                           class="btn btn-small btn-danger"
                           onclick="return confirm('Supprimer cette compétence ?');">
                            Supprimer
                        </a>
                        <a href="/admin/competences/manage?id=<?= (int)$comp['id'] ?>"
                           class="btn btn-small btn-secondary">
                            AC & Illustrations
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
