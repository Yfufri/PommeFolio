<?php require __DIR__ . "/../partials/layout_head.php"; ?>
<?php require __DIR__ . '/../partials/header.php'; ?>
<main class="page page-admin-competences">
    <section class="page-header">
        <h1>Culture générale</h1>
        <a href="culture/create" class="btn btn-primary">Ajouter un élément</a>
    </section>

    <section class="table-wrapper">
        <table class="table">
            <thead>
            <tr>
                <th>Type</th>
                <th>Titre</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item): ?>
                <tr class="table-row-hover">
                    <td><?= htmlspecialchars($item['type']) ?></td>
                    <td><?= htmlspecialchars($item['titre']) ?></td>
                    <td><?= htmlspecialchars($item['date_evenement'] ?? '') ?></td>
                    <td class="table-actions">
                        <a href="culture/edit?id=<?= (int)$item['id'] ?>" class="btn btn-small">Modifier</a>
                        <a href="culture/delete?id=<?= (int)$item['id'] ?>"
                           class="btn btn-small btn-danger"
                           onclick="return confirm('Supprimer cet élément ?');">
                            Supprimer
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
