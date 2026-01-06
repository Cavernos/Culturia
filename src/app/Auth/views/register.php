<!-- Overlay + fenêtre centrale -->

    <div class="candidature-container">
        <h1>S'inscrire</h1>

        <form class="candidature-form" action="<?= $pathFor("auth.register") ?>" method="post">
            <?= $csrf_input() ?>
            <?= $field($errors ?? [], 'role', $params["role"] ?? null, "<span class='left'>Artiste</span><span class='right'>Client</span>", ["type" => "switch"]) ?>
            <!-- Nom d'artiste -->
            <?= $field($errors ?? [], 'username', $params["username"] ?? null,  "Nom d'utilisateur : "); ?>

            <!-- Mail -->
            <?= $field($errors ?? [], 'email', $params["email"] ?? null, "Email : ", ["type" => "email"]) ?>

            <!-- Mot de passe -->
            <?= $field($errors ?? [], 'password', $params["password"] ?? null, "Mot de passe : ", ["type" => "password"]) ?>
            <?= $field($errors ?? [], 'password2', $params["password2"] ?? null, "Réécrire le mot de passe : ", ["type" => "password"]) ?>

            <!-- Catégorie d'art -->
            <?= $field($errors ?? [], 'category', null, "Categorie d'art :", ["options" => ["Option 1" => "Categorie 1"]]) ?>

            <!-- Conditions -->
            <?= $field($errors ?? [], 'cgu', $params["cgu"] ?? null, "<a href='{$pathFor('auth.cgu')}'>J’accepte les condition d’utilisation</a>", ["type" => "checkbox"]) ?>

            <!-- Bouton -->
            <div class="form-actions">
                <button type="submit" class="button">Je m'inscris</button>
            </div>

        </form>
    </div>
