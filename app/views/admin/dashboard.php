<?php require __DIR__ . "/../partials/layout_head.php"; ?>
<?php require __DIR__ . '/../partials/header.php'; ?>
<main class="page page-admin">
    <section class="admin-header">
        <h1>Panel d’administration</h1>
        <p>Gère les compétences, les AC et les illustrations de ton portfolio.</p>
    </section>

    <section class="admin-grid">
        <a href="admin/competences" class="admin-card">
            <h2>Compétences</h2>
            <p>Ajouter, modifier ou supprimer les compétences de tes années de BUT.</p>
        </a>

        <a href="admin/culture" class="admin-card">
            <h2>Culture générale</h2>
            <p>Gérer les éléments de ta culture générale (voyages, lectures, permis, etc.).</p>
        </a>
    </section>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
