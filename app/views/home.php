<?php require __DIR__ . "/partials/layout_head.php"; ?>
<?php require __DIR__ . '/partials/header.php'; ?>
<main class="page page-home">
    <section class="hero">
        <div class="hero-gradient"></div>
        <div class="hero-content">
            <h1 class="hero-title">
                Portfolio BUT Informatique
                <span class="hero-highlight">2ᵉ année</span>
            </h1>
            <p class="hero-text">
                Découvre mes compétences, mes réalisations techniques et ma culture générale
                à travers une interface fluide, animée et agréable à explorer.
            </p>
            <div class="hero-buttons">
                <a href="but" class="btn btn-primary">BUT Informatique</a>
                <a href="culture" class="btn btn-secondary">Culture générale</a>
            </div>
        </div>
    </section>

    <section class="cards-grid">
        <article class="card card-big">
            <div class="card-gradient"></div>
            <h2>BUT Informatique</h2>
            <p>
                Parcours complet de ma première année : compétences, AC, projets et illustrations
                (captures de code, PDF, vidéos).
            </p>
            <a href="but" class="card-link">Explorer les compétences →</a>
        </article>

        <article class="card card-big">
            <div class="card-gradient alt"></div>
            <h2>Culture générale</h2>
            <p>
                Voyages, lectures, permis moto et autres expériences qui complètent mon profil.
            </p>
            <a href="culture" class="card-link">Découvrir ma culture →</a>
        </article>
    </section>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>