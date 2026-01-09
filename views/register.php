<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Creer_un_compte-Culturia</title>
    <link rel="stylesheet" href="../public/assets/css/register.css">
</head>
<body>


<div class="register-container">
    <h1>Créer un compte</h1>
    <p class="subtitle">Rejoignez la communauté Culturia.</p>

    <?php if (!empty($success)): ?>
        <div class="success">
            <?php echo ($success) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="errors">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form id="registerForm" action="index.php?url=register" method="post" novalidate>
        <div class="form-group">
            <label for="email">Adresse email</label>
            <input
                type="email"
                name="email"
                id="email"
                required
                value="<?= htmlspecialchars($old['email'] ?? '') ?>"
            >
        </div>

        <div class="form-group">
            <label for="username">Nom d’utilisateur</label>
            <input
                type="text"
                name="username"
                id="username"
                required
                minlength="3"
                value="<?= htmlspecialchars($old['username'] ?? '') ?>"
            >
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input
                type="password"
                name="password"
                id="password"
                required
                minlength="8"
            >
            <p class="helper">Au moins 8 caractères, mélange lettres/chiffres/symboles.</p>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirmer le mot de passe</label>
            <input
                type="password"
                name="confirm_password"
                id="confirm_password"
                required
                minlength="8"
            >
        </div>

        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

        <button type="submit" class="btn">Créer mon compte</button>
    </form>
</div>

<script src="../public/assets/js/register.js"></script>
</body>
</html>
