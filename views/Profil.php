<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <link rel="stylesheet" href="../public/assets/css/Profil.css">
    <link rel="icon" type="image/x-icon" href="../public/assets/img/favicon.ico">
    <title>CULTURIA - Mon Profil</title>
</head>
<body>
    <?php
    $user = current_user();
    if (!$user) {
        header('Location: connexion.html');
        exit;
    }
    // Assuming additional fields like phone, city, bio are added to the model or fetched separately
    // For now, using placeholders or existing data
    $phone = $user->phone ?? '+33 6 12 34 56 78'; // Placeholder
    $city = $user->city ?? 'Paris, France'; // Placeholder
    $bio = $user->bio ?? 'Passionné d\'art depuis toujours, j\'adore découvrir de nouveaux artistes et enrichir ma collection personnelle.'; // Placeholder
    $memberSince = date('F Y', strtotime($user->inscriptionDate ?? '2020-08-01'));
    ?>
    <!-- Header -->
    <header>
        <div class="header-top">
            <!-- Logo -->
            <a href="carousel.html" class="logo">
                <img src="../public/assets/img/Logo-header.png" class="logo-img">
            </a>

            <!-- Search Bar -->
            <div class="search-container">
                <div class="search-bar">
                    <span class="search-icon"><img src="../public/assets/img/search-icon.png" alt="Rechercher"></span>
                    <input type="text" placeholder="Oeuvre, artiste, catégorie, sujet...">
                </div>
            </div>

            <!-- Header Icons -->
            <div class="header-icons">
                <!-- Favoris -->
                <a href="#" class="icon-btn">
                    <img src="../public/assets/img/favoris-icon.png" alt="Favoris">
                </a>

                <!-- Panier -->
                <a href="cart.html" class="icon-btn">
                    <img src="../public/assets/img/panier-icon.png" alt="Panier">
                </a>

                <!-- Profil -->
                <a href="/profil" class="icon-btn">
                    <img src="../public/assets/img/profil-icon.png" alt="Profil">
                </a>
            </div>
        </div>

        <!-- Navigation -->
        <nav>
            <a href="carousel.html">Accueil</a>
            <a href="shop.html">Boutique</a>
            <a href="#">Artistes</a>
            <a href="#">Galerie virtuelle</a>
            <a href="#">Contactez-nous</a>
        </nav>
    </header>


    <!-- Profile Container -->
    <div class="profile-container">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-photo" style="background-image: url('<?php echo htmlspecialchars($user->getImageURL() ?? '../public/assets/img/default-avatar.png'); ?>');"></div>
            <div class="profile-info">
                <h1><?php echo htmlspecialchars($user->username); ?></h1>
                <p>Membre Culturia depuis <?php echo htmlspecialchars($memberSince); ?></p>
            </div>

        <!-- Tabs Navigation -->
            <button class="tab-btn active" onclick="showTab('profil')">Profil</button>
            <button class="tab-btn" onclick="showTab('commandes')">Commandes</button>
            <button class="tab-btn" onclick="showTab('favoris')">Favoris</button>
            <button class="tab-btn" onclick="showTab('parametres')">Paramètres</button>
        </div>

        <!-- Tab Content: Profil -->
        <div id="profil" class="tab-content active">
            <h2>Mon Profil</h2>
            <p style="color: #666; line-height: 1.8;">
                <strong>Email :</strong> <?php echo htmlspecialchars($user->email); ?><br><br>
                <strong>Téléphone :</strong> <?php echo htmlspecialchars($phone); ?><br><br>
                <strong>Ville :</strong> <?php echo htmlspecialchars($city); ?><br><br>
                <strong>Bio :</strong> <?php echo htmlspecialchars($bio); ?>
            </p>
            <br><br>
            <button class="enregistre" onclick="window.location.href='ProfilModific.php'">Modifier mon profil</button>
        </div>

        <!-- Tab Content: Commandes -->
        <div id="commandes" class="tab-content">
            <h2>Mes Commandes</h2>
            
            <div class="order-item">
                <div class="order-image"></div>
                <div class="order-details">
                    <h3>La création d'Adam</h3>
                    <p>Peinture - Huile sur toile</p>
                    <p>Commandé le 15 novembre 2024</p>
                    <p style="color: #4c4; font-weight: bold;">✓ Livré</p>
                </div>
                <div class="order-price">2 500 €</div>
            </div>

            <div class="order-item">
                <div class="order-image"></div>
                <div class="order-details">
                    <h3>Nature morte aux fruits</h3>
                    <p>Peinture - Aquarelle</p>
                    <p>Commandé le 3 octobre 2024</p>
                    <p style="color: #4c4; font-weight: bold;">✓ Livré</p>
                </div>
                <div class="order-price">850 €</div>
            </div>

            <div class="order-item">
                <div class="order-image"></div>
                <div class="order-details">
                    <h3>Sculpture abstraite</h3>
                    <p>Sculpture - Bronze</p>
                    <p>Commandé le 12 septembre 2024</p>
                    <p style="color: #4c4; font-weight: bold;">✓ Livré</p>
                </div>
                <div class="order-price">1 200 €</div>
            </div>
        </div>

        <!-- Tab Content: Favoris -->
        <div id="favoris" class="tab-content">
            <h2>Mes Favoris</h2>
            
            <div class="order-item">
                <div class="order-image"></div>
                <div class="order-details">
                    <h3>Paysage de Provence</h3>
                    <p>Peinture - Huile sur toile</p>
                    <p>Artiste : Marie Leclerc</p>
                </div>
                <div class="order-price">3 200 €</div>
            </div>

            <div class="order-item">
                <div class="order-image"></div>
                <div class="order-details">
                    <h3>Portrait contemporain</h3>
                    <p>Peinture - Acrylique</p>
                    <p>Artiste : Jean Dubois</p>
                </div>
                <div class="order-price">1 800 €</div>
            </div>

            <div class="order-item">
                <div class="order-image"></div>
                <div class="order-details">
                    <h3>Vase céramique</h3>
                    <p>Céramique - Grès émaillé</p>
                    <p>Artiste : Sophie Martin</p>
                </div>
                <div class="order-price">450 €</div>
            </div>
        </div>

        <!-- Tab Content: Paramètres -->
        <div id="parametres" class="tab-content">
            <h2>Paramètres</h2>
            <form id="settings-form">
                <div style="color: #666; line-height: 2;">
                    <p style="margin-bottom: 20px;"><strong>Notifications</strong></p>
                    <label style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px; cursor: pointer;">
                        <input type="checkbox" name="newsletter" checked style="width: 18px; height: 18px; accent-color: #4d54c2;">
                        Recevoir la newsletter Culturia
                    </label>
                    <label style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px; cursor: pointer;">
                        <input type="checkbox" name="new_artworks" checked style="width: 18px; height: 18px; accent-color: #4d54c2;">
                        Notifications de nouvelles œuvres
                    </label>
                    <label style="display: flex; align-items: center; gap: 10px; margin-bottom: 30px; cursor: pointer;">
                        <input type="checkbox" name="promotions" style="width: 18px; height: 18px; accent-color: #4d54c2;">
                        Alertes promotions
                    </label>

                    <p style="margin-bottom: 20px;"><strong>Confidentialité</strong></p>
                    <label style="display: flex; align-items: center; gap: 10px; margin-bottom: 30px; cursor: pointer;">
                        <input type="checkbox" name="public_profile" checked style="width: 18px; height: 18px; accent-color: #4d54c2;">
                        Rendre mon profil public
                    </label>

                    <button type="submit" class="enregistre">Enregistrer les paramètres</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-section social-section">
                <h3>Nous Suivre</h3>
                <div class="social-icons">
                    <a href="#"><img src="../public/assets/img/twitter-icon.png" alt="X"></a>
                    <a href="#"><img src="../public/assets/img/instagram-icon.png" alt="Instagram"></a>
                    <a href="#"><img src="../public/assets/img/youtube-icon.png" alt="YouTube"></a>
                    <a href="#"><img src="../public/assets/img/linkedin-icon.png" alt="LinkedIn"></a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Navigation</h3>
                <ul>
                    <li><a href="#">Accueil</a></li>
                    <li><a href="#">Catégorie</a></li>
                    <li><a href="#">Artistes populaires</a></li>
                    <li><a href="#">Oeuvres populaires</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Qui sommes nous ?</h3>
                <ul>
                    <li><a href="#">À propos de nous</a></li>
                    <li><a href="#">Nous rejoindre</a></li>
                    <li><a href="#">Contactez-nous</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script>
        function showTab(tabName) {
            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(content => {
                content.classList.remove('active');
                content.style.opacity = '0';
                setTimeout(() => content.style.display = 'none', 300);
            });
            
            const buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(btn => btn.classList.remove('active'));
            
            const target = document.getElementById(tabName);
            setTimeout(() => {
                target.style.display = 'block';
                setTimeout(() => {
                    target.classList.add('active');
                    target.style.opacity = '1';
                }, 10);
            }, 300);
            event.target.classList.add('active');
        }

        // Add smooth transitions
        document.addEventListener('DOMContentLoaded', function() {
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => {
                content.style.transition = 'opacity 0.3s ease';
                if (!content.classList.contains('active')) {
                    content.style.opacity = '0';
                }
            });

            // Form submission for settings
            const form = document.getElementById('settings-form');
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                // Simulate saving settings
                const formData = new FormData(form);
                const settings = {};
                formData.forEach((value, key) => {
                    settings[key] = formData.getAll(key).includes('on'); // For checkboxes
                });
                console.log('Settings saved:', settings);
                alert('Paramètres enregistrés avec succès !');
            });

            // Add some interactivity, e.g., search bar functionality (placeholder)
            const searchInput = document.querySelector('.search-bar input');
            searchInput.addEventListener('input', function() {
                // Placeholder for search functionality
                console.log('Searching for:', this.value);
            });
        });
    </script>
</body>
</html>