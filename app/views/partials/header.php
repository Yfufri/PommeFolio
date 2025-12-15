<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="site-header">
    <div class="header-inner">
        <a href="/pommefolio/home" class="logo">
            <div class="logo-icon">
                <span class="logo-pomme"><img src="/pommefolio/public/assets/img/pome.png" alt="🍏"> </span>
            </div>
            <div class="logo-text">
                <span class="logo-name">Théo Lannier</span>
                <span class="logo-subtitle">Étudiant BUT Informatique - 2ᵉ année</span>
            </div>
        </a>

        <nav class="main-nav">
            <a href="/pommefolio/home" class="nav-link">Accueil</a>
            <a href="/pommefolio/but" class="nav-link">BUT Informatique</a>
            <a href="/pommefolio/culture" class="nav-link">Culture générale</a>

            <?php if (!empty($_SESSION['user_id'])): ?>
                <a href="/pommefolio/admin" class="nav-link nav-link-panel">Panel</a>
            <?php endif; ?>
        </nav>

        <div id="darkmode-toggle" class="darkmode-wrapper">
            <!-- Composant VueJS monté ici (slider dark mode) -->
            <div class="darkmode-switch" @click="toggleMode" :class="{ 'is-on': isDark }">
                <div class="darkmode-knob"></div>
                <span class="darkmode-icon sun">☀️</span>
                <span class="darkmode-icon moon">🌙</span>
            </div>
        </div>
    </div>
</header>
