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
                <img src="/assets/img/Logo-header.png" class="logo-img">

            </a>

            <!-- Search Bar -->
            <div class="search-container">
                <div class="search-bar">
                    <span class="search-icon"><img src="/assets/img/search-icon.png" alt="Rechercher"></span>
                    <input type="text" placeholder="Oeuvre, artiste, catégorie, sujet...">

                </div>
            </div>

            <!-- Header Icons -->
            <div class="header-icons">
                <!-- Favoris -->
                <a href="#" class="icon-btn">
                    <img src="/assets/img/favoris-icon.png" alt="Favoris">
                </a>

                <!-- Panier -->
                <a href="cart.html" class="icon-btn">
                    <img src="/assets/img/panier-icon.png" alt="Panier">
                </a>

                <!-- Profil -->
                <a href="#" class="icon-btn">
                    <img src="/assets/img/profil-icon.png" alt="Profil">
                </a>
            </div>
        </div>

        <!-- Navigation -->
        <nav>
            <?php if ($pathFor('home.index') != ''){ ?>
            <a href="<?= $pathFor('home.index') ?>">Acceuil</a>
            <?php } if ($pathFor('shop.index') != ''){ ?>
            <a href="<?=$pathFor('shop.index')?>">Boutique</a>
            <?php } if ($pathFor('artists.index') != ''){ ?>
            <a href="<?=$pathFor('artists.index')?>">Artistes</a>
            <?php } if ($pathFor('contact.index') != ''){ ?>
            <a href="<?=$pathFor('contact.index')?>">Contactez-nous</a>
            <?php } ?>
        </nav>
    </header>
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
                        <img src="/assets/img/twitter-icon.png" alt="X">
                    </a>
                    <a href="#" aria-label="Instagram">
                        <img src="/assets/img/instagram-icon.png" alt="Instagram">
                    </a>
                    <a href="#" aria-label="YouTube">
                        <img src="/assets/img/youtube-icon.png" alt="YouTube">
                    </a>
                    <a href="#" aria-label="LinkedIn">
                        <img src="/assets/img/linkedin-icon.png" alt="LinkedIn">
                    </a>
                </div>
            </div>

            <!-- Section Navigation -->
            <div class="footer-section">
                <h3>Navigation</h3>
                <ul>
                    <?php if ($pathFor("home.index") != ''){ ?>
                    <li><a href="<?= $pathFor("home.index") ?>">Accueil</a></li>
                    <?php } if ($pathFor("category.index") != ''){ ?>
                    <li><a href="<?= $pathFor("category.popular") ?>">Catégorie</a></li>
                    <?php } if ($pathFor("artists.popular") != ''){ ?>
                    <li><a href="<?= $pathFor("artists.popular") ?>">Artistes populaires</a></li>
                    <?php } if ($pathFor("shop.popular") != ''){ ?>
                    <li><a href="<?= $pathFor("shop.popular") ?>">Oeuvres populaires</a></li>
                    <?php } if ($pathFor("auth.login") != ''){ ?>
                    <li><a href="<?= $pathFor("auth.login") ?>">Connexion</a></li>
                    <?php } if ($pathFor("advice.index") != ''){ ?>
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
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Mention légal</a></li>
                </ul>
            </div>
        </div>
    </footer>
    </body>
</html>