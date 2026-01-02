

    <!-- Fond légèrement assombri + centrage de la fenêtre -->
        <div class="login-container">
            <h1>Connexion</h1>

            <form action="<?= $pathFor("auth.login") ?>" method="post" class="login-form">
                <?= $field($errors ?? [], 'role', $params["role"] ?? null, "<span class='left'>Artiste</span><span class='right'>Client</span>", ["type" => "switch"]) ?>
                <?= $field($errors ?? [], "email", $params["email"] ?? null, "E-mail :") ?>

                <!-- Mot de passe + lien "oublié ?" -->
                <?= $field($errors ?? [], "password", $params["password"] ?? null, "Mot de passe :", ["type" => "password"]) ?>
                <a href="#" class="forgot-link">Mot de passe oublié ?</a>

                <!-- Séparateur "OU" -->
                <div class="login-separator">
                    <span>OU</span>
                </div>

                <!-- Connexion avec Google / Facebook -->
                <div class="social-login">
                    <a href="#" class="social-link">Se connecter avec Google</a>
                    <a href="#" class="social-link">Se connecter avec Facebook</a>
                </div>

                <!-- Bouton principal -->
                <div class="form-actions">
                    <button type="submit" class="primary-button">
                        Je me connecte
                    </button>
                </div>

            </form>
        </div>


