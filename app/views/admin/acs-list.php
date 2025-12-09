<?php require __DIR__ . '/../partials/header.php'; ?>
<main class="page page-admin-acs">
    <section class="page-header">
        <h1>AC de la compétence <?= htmlspecialchars($competence['code']) ?> – <?= htmlspecialchars($competence['titre']) ?></h1>
        <a href="/admin/acs/create?competence_id=<?= (int)$competence['id'] ?>" class="btn btn-primary">
            Ajouter une AC
        </a>
    </section>

    <section class="table-wrapper">
        <table class="table">
            <thead>
            <tr>
                <th>Code</th>
                <th>Titre</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($acs as $ac): ?>
                <tr class="table-row-hover">
                    <td><?= htmlspecialchars($ac['code']) ?></td>
                    <td><?= htmlspecialchars($ac['titre']) ?></td>
                    <td class="table-actions">
                        <a href="/admin/acs/edit?id=<?= (int)$ac['id'] ?>" class="btn btn-small">Modifier</a>
                        <a href="/admin/acs/delete?id=<?= (int)$ac['id'] ?>"
                           class="btn btn-small btn-danger"
                           onclick="return confirm('Supprimer cette AC ?');">
                            Supprimer
                        </a>
                        <a href="/admin/illustrations?competence_id=<?= (int)$competence['id'] ?>&ac_id=<?= (int)$ac['id'] ?>"
                           class="btn btn-small btn-secondary">
                            Illustrations
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
