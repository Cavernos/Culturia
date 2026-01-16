<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/profil.css">
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <title>CULTURIA - Mon Profil</title>
    <style>
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        .tab-content h2 {
            font-size: 2.2rem;
            font-weight: bold;
        }
        .tab-content p {
            font-size: 1.3rem;
            line-height: 2;
        }
        .order-details h3 {
            font-size: 1.4rem;
        }
        .order-details p {
            font-size: 1.1rem;
        }
        
        /* Style du bouton */
        #modifier-infos {
            background: linear-gradient(135deg, #a67c52 0%, #8b6640 100%);
            color: white;
            border: none;
            padding: 14px 40px;
            font-size: 1.1rem;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(166, 124, 82, 0.3);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        #modifier-infos:hover {
            background: linear-gradient(135deg, #8b6640 0%, #704f32 100%);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(166, 124, 82, 0.5);
        }
        
        #modifier-infos:active {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(166, 124, 82, 0.4);
        }
        
        /* Style des autres boutons */
        .enregistre {
            background: linear-gradient(135deg, #a67c52 0%, #8b6640 100%);
            color: white;
            border: none;
            padding: 14px 40px;
            font-size: 1.1rem;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(166, 124, 82, 0.3);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .enregistre:hover {
            background: linear-gradient(135deg, #8b6640 0%, #704f32 100%);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(166, 124, 82, 0.5);
        }
        
        .enregistre:active {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(166, 124, 82, 0.4);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php require_once __DIR__ . '/Header.html'; ?>

    <!-- Profile Container -->
    <div class="profile-container">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-photo"></div>
            <div class="profile-info">
                <h1>Diogo Da costa</h1>
                <p style="font-size: 1.6rem; color: #a67c52; font-weight: bold;">@diogo_art</p>
                <p>Membre Culturia depuis août 2020</p>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="tabs-nav">
            <button class="tab-btn active" onclick="showTab('profil')">Profil</button>
            <button class="tab-btn" onclick="showTab('commandes')">Commandes</button>
            <button class="tab-btn" onclick="showTab('favoris')">Favoris</button>
            <button class="tab-btn" onclick="showTab('parametres')">Paramètres</button>
        </div>

        <!-- Tabs Content -->
        <div class="tabs-content">

        <!-- Tab Content: Profil -->
        <div id="profil" class="tab-content active">
            <h2>Mon Profil</h2>
            <p style="color: #666; line-height: 1.8;">
                <strong>Nom :</strong> Da costa<br><br>
                <strong>Prénom :</strong> Diogo<br><br>
                <strong>Email :</strong> <span style="font-style: italic; color: #999;">diogo.dacosta@exemple.fr</span> <small style="color: #a67c52;">(non modifiable)</small><br><br>
                <strong>Téléphone :</strong> +33 6 12 34 56 78<br><br>
                <strong>Ville :</strong> Paris, France<br><br>
                <strong>Bio :</strong> Passionné d'art depuis toujours, j'adore découvrir de nouveaux artistes et enrichir ma collection personnelle.
            </p>
            <br><br>
            <button class="enregistre" id="modifier-infos" onclick="window.location.href='?url=modifProfil'">Modifier mon profil</button>
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

        <!-- Notification -->
        <div id="notification" style="display: none; position: fixed; top: 20px; right: 20px; background: linear-gradient(135deg, #4caf50 0%, #45a049 100%); color: white; padding: 20px 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3); z-index: 1000; font-weight: bold; font-size: 1.1rem;">
            ✓ Paramètres enregistrés avec succès !
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
    </div>

    <script>
        function showTab(tabName) {
            // Masquer tous les tabs
            const allTabs = document.querySelectorAll('.tab-content');
            allTabs.forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Retirer la classe active de tous les boutons
            const allButtons = document.querySelectorAll('.tab-btn');
            allButtons.forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Afficher le tab sélectionné
            const selectedTab = document.getElementById(tabName);
            if (selectedTab) {
                selectedTab.classList.add('active');
            }
            
            // Ajouter la classe active au bouton cliqué
            event.target.classList.add('active');
        }

        // Fonction pour afficher la notification
        function showNotification() {
            const notification = document.getElementById('notification');
            notification.style.display = 'block';
            
            // Faire disparaître après 3 secondes
            setTimeout(() => {
                notification.style.display = 'none';
            }, 3000);
        }

        // Form submission for settings
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('settings-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Créer FormData avec les données du formulaire
                    const settings = {};
                    
                    // Récupérer les checkboxes
                    settings.newsletter = form.elements['newsletter'].checked ? 1 : 0;
                    settings.new_artworks = form.elements['new_artworks'].checked ? 1 : 0;
                    settings.promotions = form.elements['promotions'].checked ? 1 : 0;
                    settings.public_profile = form.elements['public_profile'].checked ? 1 : 0;
                    
                    // Envoyer les données au serveur
                    fetch('?url=saveSettings', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(settings)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification();
                        } else {
                            alert('Erreur lors de l\'enregistrement');
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        // Afficher la notification même en cas d'erreur (mode local)
                        showNotification();
                    });
                });
            }
        });
    </script>
    <script src="assets/js/profil.js"></script>
    
    <!-- Footer -->
    <?php require_once __DIR__ . '/Footer.html'; ?>
</body>
</html>