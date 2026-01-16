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
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .tab-content h2 { font-size: 2.2rem; font-weight: bold; }
        .tab-content p { font-size: 1.3rem; line-height: 2; }
        .order-details h3 { font-size: 1.4rem; }
        .order-details p { font-size: 1.1rem; }
        
        #modifier-infos, .enregistre {
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
        
        #modifier-infos:hover, .enregistre:hover {
            background: linear-gradient(135deg, #8b6640 0%, #704f32 100%);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(166, 124, 82, 0.5);
        }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/Header.html'; ?>

    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-photo" style="background-image: url('<?= !empty($profile['photo_path']) ? htmlspecialchars($profile['photo_path']) : 'assets/img/default-avatar.png' ?>'); background-size: cover; background-position: center;"></div>
            
            <div class="profile-info">
                <h1><?= htmlspecialchars($profile['prenom'] . ' ' . $profile['nom']) ?></h1>
                <p style="font-size: 1.6rem; color: #a67c52; font-weight: bold;">@<?= htmlspecialchars($profile['nom_utilisateur']) ?></p>
                <p>Membre Culturia depuis <?= isset($profile['created_at']) ? date('M Y', strtotime($profile['created_at'])) : 'août 2020' ?></p>
            </div>
        </div>

        <div class="tabs-nav">
            <button class="tab-btn active" onclick="showTab('profil')">Profil</button>
            <button class="tab-btn" onclick="showTab('commandes')">Commandes</button>
            <button class="tab-btn" onclick="showTab('favoris')">Favoris</button>
            <button class="tab-btn" onclick="showTab('parametres')">Paramètres</button>
        </div>

        <div class="tabs-content">

            <div id="profil" class="tab-content active">
                <h2>Mon Profil</h2>
                <div style="color: #666; line-height: 1.8; font-size: 1.3rem; margin-top: 20px;">
                    <p><strong>Nom :</strong> <?= htmlspecialchars($profile['nom']) ?></p>
                    <p><strong>Prénom :</strong> <?= htmlspecialchars($profile['prenom']) ?></p>
                    <p><strong>Email :</strong> <span style="font-style: italic; color: #999;"><?= htmlspecialchars($profile['email']) ?></span> <small style="color: #a67c52;">(non modifiable)</small></p>
                    <p><strong>Téléphone :</strong> <?= !empty($profile['telephone']) ? htmlspecialchars($profile['telephone']) : 'Non renseigné' ?></p>
                    <p><strong>Ville :</strong> <?= !empty($profile['ville']) ? htmlspecialchars($profile['ville']) : 'Non renseignée' ?><?= !empty($profile['pays']) ? ', ' . htmlspecialchars($profile['pays']) : '' ?></p>
                    <p><strong>Bio :</strong> <?= !empty($profile['biographie']) ? nl2br(htmlspecialchars($profile['biographie'])) : 'Aucune biographie rédigée.' ?></p>
                </div>
                <br><br>
                <button class="enregistre" id="modifier-infos" onclick="window.location.href='?url=modifProfil'">Modifier mon profil</button>
            </div>

            <div id="commandes" class="tab-content">
                <h2>Mes Commandes</h2>
                <p style="font-size: 1.1rem; color: #888;">Historique de vos acquisitions</p>
                <div class="order-item">
                    <div class="order-image"></div>
                    <div class="order-details">
                        <h3>La création d'Adam</h3>
                        <p>Peinture - Huile sur toile</p>
                        <p style="color: #4c4; font-weight: bold;">✓ Livré</p>
                    </div>
                    <div class="order-price">2 500 €</div>
                </div>
            </div>

            <div id="favoris" class="tab-content">
                <h2>Mes Favoris</h2>
                <div class="order-item">
                    <div class="order-image"></div>
                    <div class="order-details">
                        <h3>Paysage de Provence</h3>
                        <p>Artiste : Marie Leclerc</p>
                    </div>
                    <div class="order-price">3 200 €</div>
                </div>
            </div>

            <div id="parametres" class="tab-content">
                <h2>Paramètres</h2>
                <form id="settings-form">
                    <div style="color: #666; line-height: 2;">
                        <p style="margin-bottom: 20px;"><strong>Notifications</strong></p>
                        <label style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px; cursor: pointer;">
                            <input type="checkbox" name="newsletter" checked style="width: 18px; height: 18px; accent-color: #a67c52;">
                            Recevoir la newsletter Culturia
                        </label>
                        <label style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px; cursor: pointer;">
                            <input type="checkbox" name="new_artworks" checked style="width: 18px; height: 18px; accent-color: #a67c52;">
                            Notifications de nouvelles œuvres
                        </label>
                        <p style="margin-bottom: 20px; margin-top: 20px;"><strong>Confidentialité</strong></p>
                        <label style="display: flex; align-items: center; gap: 10px; margin-bottom: 30px; cursor: pointer;">
                            <input type="checkbox" name="public_profile" checked style="width: 18px; height: 18px; accent-color: #a67c52;">
                            Rendre mon profil public
                        </label>
                        <button type="submit" class="enregistre">Enregistrer les paramètres</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div id="notification" style="display: none; position: fixed; top: 20px; right: 20px; background: linear-gradient(135deg, #4caf50 0%, #45a049 100%); color: white; padding: 20px 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3); z-index: 1000; font-weight: bold; font-size: 1.1rem;">
        ✓ Paramètres enregistrés avec succès !
    </div>

    <script>
        function showTab(tabName) {
            const allTabs = document.querySelectorAll('.tab-content');
            allTabs.forEach(tab => tab.classList.remove('active'));
            
            const allButtons = document.querySelectorAll('.tab-btn');
            allButtons.forEach(btn => btn.classList.remove('active'));
            
            document.getElementById(tabName).classList.add('active');
            event.currentTarget.classList.add('active');
        }

        // Script fetch pour les paramètres (déjà présent dans votre version)
        document.getElementById('settings-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const notification = document.getElementById('notification');
            notification.style.display = 'block';
            setTimeout(() => { notification.style.display = 'none'; }, 3000);
        });
    </script>
    
    <?php require_once __DIR__ . '/Footer.html'; ?>
</body>
</html>