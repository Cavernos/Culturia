<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <link rel="stylesheet" href="/assets/css/style.css"/>
        <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">
        <title>Culturia</title>
    </head>
    <body>
    <header>
        <div class="header-top">
            <!-- Logo -->
            <a href="<?= $pathFor("home.index") ?>" class="logo">
                <img src="/assets/img/logo.svg" class="logo-img" alt="Logo">

            </a>
            <?php if ( $pathFor('search.index') != ''){ ?>
            <!-- Search Bar -->
            <div class="search-container">
                <div class="search-bar">
                    <span class="search-icon"><img src="/assets/img/search-icon.png" alt="Rechercher"></span>
                    <input type="text" placeholder="Oeuvre, artiste, catégorie, sujet...">

                </div>
            </div>
            <?php } ?>

            <!-- Header Icons -->
            <div class="header-icons">
                <!-- Favoris -->
                <a href="#" class="icon-btn">
                    <img src="/assets/img/favoris.svg" alt="Favoris">
                </a>

                <?php if ( $pathFor('shop.cart.index') != '' && $current_user()){ ?>
                <!-- Panier -->
                <a href="<?= $pathFor('shop.cart.index') ?>" class="icon-btn">
                    <div class="cart-count"><?=  count($session->get("carts")[$current_user()->id] ?? []) ?></div>
                    <img src="/assets/img/cart.svg" alt="Panier">
                </a>
                <?php } ?>

                <!-- Profil -->
                <?php if ( $pathFor('auth.login') != ''){ ?>
                <a href="#login" class="icon-btn">
                    <img src="/assets/img/account.svg" alt="Profil">
                </a>
                    <?php if ($current_user()) { ?>
                       <h2><?= $current_user()->username ?></h2>
                        <?php if($pathFor("auth.logout") != '') { ?>
                            <form action="<?= $pathFor("auth.logout") ?>" method="post">
                                <button type="submit" class="button">Se déconnecter</button>
                            </form>

                        <?php } ?>
                    <?php }?>
                <?php } ?>
            </div>
        </div>

        <!-- Navigation -->
        <nav>
            <?php if ( $pathFor('home.index') != ''){ ?>
            <a href="<?= $pathFor('home.index') ?>">Accueil</a>
            <?php } if ( $pathFor('shop.index') != ''){ ?>
            <a href="<?= $pathFor('shop.index')?>">Boutique</a>
            <?php } if ( $pathFor('artists.index') != ''){ ?>
            <a href="<?= $pathFor('artists.index')?>">Artistes</a>
            <?php } if ( $pathFor('contact.index') != ''){ ?>
            <a href="<?= $pathFor('contact.index')?>">Contactez-nous</a>
            <?php } ?>
        </nav>
    </header>
    <?php if($flash("error")) { ?>
        <div class="alert alert-danger"><?= $flash("error") ?></div>
    <?php } ?>
    <?php if($flash("success")) { ?>
        <div class="alert alert-success"><?= $flash("success") ?></div>
    <?php } ?>
        <main class="main-container">
            <?php require($path); ?>
        </main>
    <footer>
        <div class="footer-container">
            <!-- Section Nous Suivre -->
            <div class="footer-section social-section">
                <h3>Nous Suivre</h3>
                <div class="social-icons">
                    <a href="#" aria-label="Twitter">
                        <img src="/assets/img/X.svg" alt="X">
                    </a>
                    <a href="#" aria-label="Instagram">
                        <img src="/assets/img/instagram.svg" alt="Instagram">
                    </a>
                    <a href="#" aria-label="YouTube">
                        <img src="/assets/img/youtube.svg" alt="YouTube">
                    </a>
                    <a href="#" aria-label="LinkedIn">
                        <img src="/assets/img/linkedIn.svg" alt="LinkedIn">
                    </a>
                </div>
            </div>

            <!-- Section Navigation -->
            <div class="footer-section">
                <h3>Navigation</h3>
                <ul>
                    <?php if ( $pathFor("home.index") != ''){ ?>
                    <li><a href="<?= $pathFor("home.index") ?>">Accueil</a></li>
                    <?php } if ( $pathFor("category.index") != ''){ ?>
                    <li><a href="<?= $pathFor("category.popular") ?>">Catégorie</a></li>
                    <?php } if ( $pathFor("artists.popular") != ''){ ?>
                    <li><a href="<?= $pathFor("artists.popular") ?>">Artistes populaires</a></li>
                    <?php } if ( $pathFor("shop.popular") != ''){ ?>
                    <li><a href="<?= $pathFor("shop.popular") ?>">Oeuvres populaires</a></li>
                    <?php } if ( $pathFor("auth.login") != ''){ ?>
                    <li><a href="<?= $pathFor("auth.login") ?>">Connexion</a></li>
                    <?php } if ( $pathFor("advice.index") != ''){ ?>
                    <li><a href="<?= $pathFor("advice.index") ?>">Avis</a></li>
                    <?php } ?>
                </ul>
            </div>

            <!-- Section Qui sommes nous -->
            <div class="footer-section">
                <h3>Qui sommes nous ?</h3>
                <ul>
                    <li><a href="#">À propos de nous</a></li>
                    <li><a href="#">Nous rejoindre</a></li>
                    <li><a href="#">Contactez-nous</a></li>
                    <?php if ( $pathFor("home.faq") != ''){ ?>
                    <li><a href="<?= $pathFor("home.faq") ?>">FAQ</a></li>
                    <?php } ?>
                    <li><a href="#">Mention légal</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <aside id="login" class="login-overlay">
        <!-- Fond légèrement assombri + centrage de la fenêtre -->
        <div class="login-modal">

            <h1>Connexion</h1>

            <form action="<?= $pathFor("auth.login") ?>" method="post" class="login-form">

                <?= $field(["errors" => $errors ?? []], "email", null, "E-mail :") ?>

                <!-- Mot de passe + lien "oublié ?" -->
                <?= $field(["errors" => $errors ?? []], "password", null, "Mot de passe :", ["type" => "password"]) ?>
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
                    <button type="submit" class="button">
                        Je me connecte
                    </button>
                    <a href="#" class="button">Fermer</a>
                </div>
            </form>
        </div>


    </aside>
    </body>
</html>