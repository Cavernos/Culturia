<!-- Overlay + fenêtre centrale -->

    <div class="candidature-container">
        <h1>Candidater</h1>

        <form class="candidature-form" action="<?= $pathFor("auth.register") ?>" method="post">
            <div class='form-group'>
                <input type='hidden' role value='0'/>
                <input type='checkbox' id="role" name="role" value='1'/>
                <label for='role' class="form-switch">
                    <span class="left">Artiste</span>
                    <span class="right">Client</span>
                </label>
                <small><?= $errors["role"] ?? '' ?></small>
            </div>
            <!-- Nom d'artiste -->
            <?= $field(["errors" => $errors ?? []], 'username', $params["username"] ?? null,  "Nom d'utilisateur : "); ?>

            <!-- Mail -->
            <?= $field(["errors" => $errors ?? []], 'email', $params["email"] ?? null, "Email : ", ["type" => "email"]) ?>

            <!-- Mot de passe -->
            <?= $field(["errors" => $errors ?? []], 'password', $params["password"] ?? null, "Mot de passe : ", ["type" => "password"]) ?>
            <?= $field(["errors" => $errors ?? []], 'password2', $params["password2"] ?? null, "Réécrire le mot de passe : ", ["type" => "password"]) ?>

            <!-- Catégorie d'art -->
            <?= $field(["errors" => $errors ?? []], 'category', null, "Categorie d'art :", ["options" => ["Option 1" => "Categorie 1"]]) ?>

            <!-- Conditions -->
            <?= $field(["errors" => $errors ?? []], 'cgu', $params["cgu"] ?? null, "<a href='{$pathFor('auth.cgu')}'>J’accepte les condition d’utilisation</a>", ["type" => "checkbox"]) ?>

            <!-- Bouton -->
            <div class="form-actions">
                <button type="submit" class="button">Je candidate</button>
            </div>

        </form>
    </div>
