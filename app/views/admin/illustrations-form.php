<?php require __DIR__ . "/../partials/layout_head.php"; ?>
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
            <form action="illustrations/store" method="post" enctype="multipart/form-data" class="form">
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
                    <p class="form-hint">Uploade un fichier (image, pdf, mp4) <strong>ou</strong> colle une URL.</p>
                    <input type="file" name="file_upload" class="input-file">
                    <p class="form-or">ou</p>
                    <input type="text" name="url" placeholder="https://..." class="input-text">
                </div>

                <div class="form-group">
                    <label for="titre">Titre (optionnel)</label>
                    <input type="text" id="titre" name="titre" placeholder="Ex: Maquette du projet...">
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
                        <option value="">-- Choisir une AC (si portée AC sélectionnée) --</option>
                        <?php foreach ($acsDeLaCompetence as $acItem): ?>
                            <option value="<?= (int)$acItem['id'] ?>" <?= (isset($ac) && $ac['id'] == $acItem['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($acItem['code']) ?> – <?= htmlspecialchars($acItem['titre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Enregistrer l’illustration</button>
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
                    <th>Aperçu / Path</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($illustrations)): ?>
                    <tr><td colspan="5">Aucune illustration pour le moment.</td></tr>
                <?php else: ?>
                    <?php foreach ($illustrations as $illu): ?>
                        <tr class="table-row-hover">
                            <td><?= htmlspecialchars($illu['titre'] ?? 'Sans titre') ?></td>
                            <td><span class="tag-type"><?= htmlspecialchars($illu['type']) ?></span></td>
                            <td>
                                <?php if (!empty($illu['ac_code'])): ?>
                                    <small>AC <?= htmlspecialchars($illu['ac_code']) ?></small>
                                <?php else: ?>
                                    <small>Globale</small>
                                <?php endif; ?>
                            </td>
                            <td class="text-truncate" style="max-width: 200px;">
                                <small><?= htmlspecialchars($illu['path']) ?></small>
                            </td>
                            <td class="table-actions">
                                <a href="illustrations/delete?id=<?= (int)$illu['id'] ?>"
                                   class="btn btn-small btn-danger"
                                   onclick="return confirm('Supprimer cette illustration ?');">
                                    Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>

<?php require __DIR__ . '/../partials/footer.php'; ?>