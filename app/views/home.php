<?php require __DIR__ . "/partials/layout_head.php"; ?>
<?php require __DIR__ . '/partials/header.php'; ?>
<main class="page page-home">
    <section class="hero">
        <div class="hero-gradient"></div>
        <div class="hero-content">
            <h1 class="hero-title">
                Portfolio
                <span class="hero-highlight">BUT Informatique</span>
            </h1>
            <p class="hero-text">
                Découvre mes compétences, mes réalisations techniques et mes enrichissements culturels
                à travers une interface agréable à explorer.
            </p>
            <div class="hero-buttons">
                <a href="/pommefolio/but" class="btn btn-primary">BUT Informatique</a>
                <a href="/pommefolio/culture" class="btn btn-secondary">Culture générale</a>
            </div>
        </div>
    </section>

    <section class="cards-grid">
        <article class="card">
            <div class="card-gradient"></div>
            <h2>BUT Informatique</h2>
            <p>
                Parcours complet de mes années d'études : compétences, AC, projets et illustrations
                (captures de code, PDF, vidéos).
            </p>
            <a href="/pommefolio/but" class="card-link">Explorer les compétences →</a>
        </article>

        <article class="card">
            <div class="card-gradient alt"></div>
            <h2>Culture Générale</h2>
            <p>
                Voyages, lectures, sports et autres expériences qui complètent mon profil d'étudiant.
            </p>
            <a href="/pommefolio/culture" class="card-link">Découvrir mes enrichissements culturels →</a>
        </article>
    </section>

    <article class="card">
        <h2>Mon CV</h2>
        <div class="pdf-container">
            <iframe
                    src="public/assets/img/CV.pdf#toolbar=0"
                    type="application/pdf"
                    class="illu-pdf"
                    width="100%"
                    height="500px">
            </iframe>
            <div class="pdf-fallback">
                <a href="public/assets/img/CV.pdf" target="_blank" class="btn btn-link">
                    Ouvrir le CV dans un nouvel onglet (Plein écran) →
                </a>
            </div>
        </div>
    </article>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>