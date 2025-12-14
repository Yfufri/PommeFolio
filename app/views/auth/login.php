<?php require __DIR__ . "/../partials/layout_head.php"; ?>
<?php require __DIR__ . '/../partials/header.php'; ?>
<main class="page page-login">
    <section class="login-card">
        <div class="login-gradient"></div>
        <h1>Connexion</h1>
        <?php if (!empty($error)): ?>
            <p class="login-error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="login/submit" method="post" class="form">

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required autocomplete="current-password">
            </div>

            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </section>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
