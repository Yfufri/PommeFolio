<?php require __DIR__ . '/../partials/header.php'; ?>
<main class="page page-admin-illustrations">
    <section class="page-header">
        <h1>Illustrations – <?= htmlspecialchars($competence['code']) ?> – <?= htmlspecialchars($competence['titre']) ?></h1>
        <?php if (!empty($ac)): ?>
            <p>AC ciblée : <?= htmlspecialchars($ac['code']) ?> – <?= htmlspecialchars($ac['titre']) ?></p>
        <?php endif; ?>
    </section>

    <section class="form-wrapper">
        <h2>Ajouter une illustration</h2>
        <form action="/admin/illustrations/store" method="post" enctype="multipart/form-data" class="form">
            <input type="hidden" name="competence_id" value="<?= (int)$competence['id'] ?>">

            <div class="form-group">
                <label for="type">Type d’illustration</label>
                <select id="type" name="type" required>
                    <option value="image">Image</option>
                    <option value="pdf">PDF</option>
                    <option value="video">Vidéo</option>
                    <option value="url">Lien externe</option>
                </select>
            </div>

            <div class="form-group">
                <label>Source</label>
                <p class="form-hint">Selon le type, tu peux soit uploader un fichier, soit fournir une URL.</p>
                <input type="file" name="file_upload" class="input-file">
                <p class="form-or">ou</p>
                <input type="text" name="url" placeholder="https://..." class="input-text">
            </div>

            <div class="form-group">
                <label for="titre">Titre (optionnel)</label>
                <input type="text" id="titre" name="titre">
            </div>

            <div class="form-group">
                <label>Portée de l’illustration</label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="scope" value="global" checked>
                        Globale à la compétence
                    </label>
                    <label>
                        <input type="radio" name="scope" value="ac">
                        Spécifique à une AC
                    </label>
                </div>
                <select name="ac_id" class="select-ac">
                    <option value="">Sélectionner une AC</option>
                    <?php foreach ($acsDeLaCompetence as $acItem): ?>
                        <option value="<?= (int)$acItem['id'] ?>">
                            <?= htmlspecialchars($acItem['code']) ?> – <?= htmlspecialchars($acItem['titre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Ajouter l’illustration</button>
        </form>
    </section>

    <section class="table-wrapper">
        <h2>Illustrations existantes</h2>
        <table class="table">
            <thead>
            <tr>
                <th>Titre</th>
                <th>Type</th>
                <th>Portée</th>
                <th>Chemin / URL</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($illustrations as $illu): ?>
                <tr class="table-row-hover">
                    <td><?= htmlspecialchars($illu['titre'] ?? '') ?></td>
                    <td><?= htmlspecialchars($illu['type']) ?></td>
                    <td>
                        <?php if (!empty($illu['ac_code'])): ?>
                            AC <?= htmlspecialchars($illu['ac_code']) ?>
                        <?php else: ?>
                            Globale
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($illu['path']) ?></td>
                    <td class="table-actions">
                        <a href="/admin/illustrations/delete?id=<?= (int)$illu['id'] ?>"
                           class="btn btn-small btn-danger"
                           onclick="return confirm('Supprimer cette illustration ?');">
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
