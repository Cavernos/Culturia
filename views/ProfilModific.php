<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <link rel="stylesheet" href="../public/assets/css/profile.css">
    <link rel="icon" type="image/x-icon" href="../public/assets/img/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier mon profil - Culturia</title>
    <style>
        @keyframes slideIn {
            from { transform: translateX(400px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>
</head>
<body>
    <?php include 'header.html'; ?>
    
    <div class="Profilcontainer">
        <h1 class="page-title">Modifier mon profil</h1>
        
        <div class="profile-header">
            <div class="profile-photo-container">
                <?php 
                $photoSrc = !empty($profile['photo_path']) ? htmlspecialchars($profile['photo_path']) : "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='150' height='150'%3E%3Ccircle cx='75' cy='75' r='75' fill='%23a67c52'/%3E%3Ctext x='50%25' y='50%25' text-anchor='middle' dy='.3em' fill='white' font-size='60' font-family='Georgia'%3EDD%3C/text%3E%3C/svg%3E";
                ?>
                <img src="<?= $photoSrc ?>" alt="Photo de profil" class="profile-photo" id="profilePhoto">
                <button type="button" class="photo-upload-btn" onclick="document.getElementById('photoInput').click()">
                    +
                    <input type="file" id="photoInput" accept="image/*" onchange="updateProfilePhoto(event)">
                </button>
            </div>
        </div>

        <form id="profileForm">
            <h2 class="section-title">Informations personnelles</h2>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="firstName">Prénom <span class="required">*</span></label>
                    <input type="text" id="firstName" name="firstName" value="<?= htmlspecialchars($profile['prenom'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="lastName">Nom <span class="required">*</span></label>
                    <input type="text" id="lastName" name="lastName" value="<?= htmlspecialchars($profile['nom'] ?? '') ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="username">Nom d'utilisateur <span class="required">*</span></label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($profile['nom_utilisateur'] ?? '') ?>" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($profile['email'] ?? '') ?>" readonly style="background-color: #f5f5f5; cursor: not-allowed; color: #999;">
                    <small style="color: #a67c52; font-style: italic;">Ce champ ne peut pas être modifié</small>
                </div>

                <div class="form-group">
                    <label for="phone">Téléphone</label>
                    <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($profile['telephone'] ?? '') ?>" placeholder="+33 6 12 34 56 78" onchange="validatePhone()">
                    <small id="phoneError" style="color: #ff4444; display: none;">Format invalide. Utilisez le format: +33 6 12 34 56 78</small>
                </div>
            </div>

            <div class="form-group">
                <label for="bio">Biographie</label>
                <textarea id="bio" name="bio" placeholder="Parlez-nous de vous, votre parcours artistique, vos inspirations..."><?= htmlspecialchars($profile['biographie'] ?? '') ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="city">Ville</label>
                    <input type="text" id="city" name="city" value="<?= htmlspecialchars($profile['ville'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="country">Pays</label>
                    <input type="text" id="country" name="country" value="<?= htmlspecialchars($profile['pays'] ?? '') ?>">
                </div>
            </div>

            <h2 class="section-title">Informations artistiques</h2>

            <div class="form-group">
                <label for="artistType">Type d'artiste</label>
                <select id="artistType" name="artistType">
                    <?php $type = strtolower($profile['type_artiste'] ?? ''); ?>
                    <option value="peintre" <?= $type == 'peintre' ? 'selected' : '' ?>>Peintre</option>
                    <option value="sculpteur" <?= $type == 'sculpteur' ? 'selected' : '' ?>>Sculpteur</option>
                    <option value="photographe" <?= $type == 'photographe' ? 'selected' : '' ?>>Photographe</option>
                    <option value="illustrateur" <?= $type == 'illustrateur' ? 'selected' : '' ?>>Illustrateur</option>
                    <option value="ceramiste" <?= $type == 'ceramiste' ? 'selected' : '' ?>>Céramiste</option>
                    <option value="mixte" <?= $type == 'mixte' ? 'selected' : '' ?>>Art mixte</option>
                </select>
            </div>

            <div class="form-group">
                <label for="specialties">Spécialités (séparées par des virgules)</label>
                <input type="text" id="specialties" name="specialties" value="<?= htmlspecialchars($profile['specialites'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="experience">Années d'expérience</label>
                <input type="text" id="experience" name="experience" value="<?= htmlspecialchars($profile['annees_experience'] ?? '') ?>">
            </div>

            <h2 class="section-title">Réseaux sociaux & Site web</h2>

            <div class="social-links">
                <div class="form-group">
                    <label for="website">Site web personnel</label>
                    <input type="url" id="website" name="website" value="<?= htmlspecialchars($profile['site_web'] ?? '') ?>" placeholder="https://">
                </div>

                <div class="form-group">
                    <label for="instagram">Instagram</label>
                    <input type="text" id="instagram" name="instagram" value="<?= htmlspecialchars($profile['instagram'] ?? '') ?>" placeholder="@votre_compte">
                </div>

                <div class="form-group">
                    <label for="facebook">Facebook</label>
                    <input type="url" id="facebook" name="facebook" value="<?= htmlspecialchars($profile['facebook'] ?? '') ?>" placeholder="https://facebook.com/...">
                </div>

                <div class="form-group">
                    <label for="twitter">Twitter / X</label>
                    <input type="text" id="twitter" name="twitter" value="<?= htmlspecialchars($profile['twitter_x'] ?? '') ?>" placeholder="@votre_compte">
                </div>
            </div>

            <h2 class="section-title">Sécurité</h2>

            <div class="form-group">
                <label for="currentPassword">Mot de passe actuel</label>
                <input type="password" id="currentPassword" name="currentPassword" placeholder="Laissez vide si pas de changement">
            </div>

            <div class="form-group">
                <label for="newPassword">Nouveau mot de passe</label>
                <input type="password" id="newPassword" name="newPassword" placeholder="Minimum 8 caractères" onkeyup="checkPasswordStrength()">
                <div id="passwordStrength" style="margin-top: 20px; display: none;">
                    <p style="font-weight: bold; margin-bottom: 16px; font-size: 1.4rem;">Force du mot de passe :</p>
                    <div style="background-color: #f0f0f0; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                        <div id="strengthBar" style="height: 24px; background-color: #ddd; border-radius: 6px; overflow: hidden;">
                            <div id="strengthLevel" style="height: 100%; width: 0%; background-color: #ff4444; transition: all 0.3s ease;"></div>
                        </div>
                    </div>
                    <p id="strengthText" style="font-size: 1.3rem; color: #666; margin-bottom: 16px; font-weight: bold;"></p>
                    <div id="passwordChecklist" style="font-size: 1.2rem; line-height: 2.2;">
                        <p style="margin: 12px 0;"><span id="check-length">❌</span> <strong>Au moins 8 caractères</strong></p>
                        <p style="margin: 12px 0;"><span id="check-upper">❌</span> <strong>Au moins une majuscule (A-Z)</strong></p>
                        <p style="margin: 12px 0;"><span id="check-lower">❌</span> <strong>Au moins une minuscule (a-z)</strong></p>
                        <p style="margin: 12px 0;"><span id="check-number">❌</span> <strong>Au moins un chiffre (0-9)</strong></p>
                        <p style="margin: 12px 0;"><span id="check-special">❌</span> <strong>Au moins un caractère spécial (!@#$%^&*)</strong></p>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="confirmPassword">Confirmer le nouveau mot de passe</label>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Répétez le mot de passe" onkeyup="checkPasswordMatch()">
                <p id="passwordMatchMessage" style="display: none; margin-top: 8px; font-weight: bold;"></p>
            </div>

            <div class="button-group">
                <button type="button" class="btn-danger" onclick="showDeleteModal()">Supprimer le compte</button>
                <button type="submit" class="btn-primary">Enregistrer</button>
                <button type="button" class="btn-secondary" onclick="window.location.href='?url=profil'">Annuler</button>
            </div>
        </form>
    </div>

    <?php include 'footer.html'; ?>

    <script>
    // --- FONCTIONS GLOBALES (IMPORTANT pour que onkeyup fonctionne) ---

    // Fonction de vérification de la force du mot de passe
    function checkPasswordStrength() {
        const password = document.getElementById('newPassword').value;
        const strengthDiv = document.getElementById('passwordStrength');
        const strengthBar = document.getElementById('strengthLevel');
        const strengthText = document.getElementById('strengthText');

        if (password.length === 0) {
            strengthDiv.style.display = 'none';
            return;
        }

        strengthDiv.style.display = 'block';

        // Vérifications
        const hasLength = password.length >= 8;
        const hasUpper = /[A-Z]/.test(password);
        const hasLower = /[a-z]/.test(password);
        const hasNumber = /[0-9]/.test(password);
        const hasSpecial = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);

        // Mise à jour des cases à cocher
        updateCheck('check-length', hasLength);
        updateCheck('check-upper', hasUpper);
        updateCheck('check-lower', hasLower);
        updateCheck('check-number', hasNumber);
        updateCheck('check-special', hasSpecial);

        // Calcul de la force
        let strength = 0;
        if (hasLength) strength++;
        if (hasUpper) strength++;
        if (hasLower) strength++;
        if (hasNumber) strength++;
        if (hasSpecial) strength++;

        // Mise à jour de la barre et du texte
        const percentages = [0, 20, 40, 60, 80, 100];
        strengthBar.style.width = percentages[strength] + '%';

        const colors = ['#ff4444', '#ff9944', '#ffdd44', '#dddd44', '#88dd44', '#44dd44'];
        strengthBar.style.backgroundColor = colors[strength];

        const labels = ['Très faible', 'Faible', 'Moyen', 'Bon', 'Très bon', 'Excellent'];
        strengthText.textContent = 'Force : ' + labels[strength];
        strengthText.style.color = colors[strength];
    }

    function updateCheck(elementId, isValid) {
        const element = document.getElementById(elementId);
        if (isValid) {
            element.textContent = '✅';
            element.style.color = '#44dd44';
        } else {
            element.textContent = '❌';
            element.style.color = '#ff4444';
        }
    }

    // Fonction de vérification de la correspondance des mots de passe
    function checkPasswordMatch() {
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        const message = document.getElementById('passwordMatchMessage');

        if (confirmPassword.length === 0) {
            message.style.display = 'none';
            return;
        }

        message.style.display = 'block';
        if (newPassword === confirmPassword) {
            message.textContent = '✅ Les mots de passe correspondent';
            message.style.color = '#44dd44';
        } else {
            message.textContent = '❌ Les mots de passe ne correspondent pas';
            message.style.color = '#ff4444';
        }
    }

    // Fonction pour mise à jour photo (accessible globalement pour onchange)
    function updateProfilePhoto(event) {
        const file = event.target.files[0];
        if (file) {
            if (!file.type.startsWith('image/')) {
                alert('Veuillez sélectionner une image valide');
                event.target.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profilePhoto').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    // Validation du téléphone (accessible globalement pour onchange)
    function validatePhone() {
        const phone = document.getElementById('phone').value;
        const phoneError = document.getElementById('phoneError');
        const phoneRegex = /^(\+33|0)[1-9](\s?\d{2}){4}$|^\+33\s?[1-9](\s?\d{2}){4}$/;
        
        if (phone && !phoneRegex.test(phone.replace(/\s/g, ''))) {
            phoneError.style.display = 'block';
            document.getElementById('phone').style.borderColor = '#ff4444';
        } else {
            phoneError.style.display = 'none';
            document.getElementById('phone').style.borderColor = '#ddd';
        }
    }

    // --- DOM Loaded Listener ---
    document.addEventListener('DOMContentLoaded', function() {
        const profileForm = document.getElementById('profileForm');
        
        // Form submission logic
        profileForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Validation interne avant envoi
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const currentPassword = document.getElementById('currentPassword').value;
            
            if (newPassword || confirmPassword) {
                if (!currentPassword) {
                    alert('Le mot de passe actuel est requis pour changer de mot de passe');
                    return;
                }
                if (newPassword !== confirmPassword) {
                    alert('Les mots de passe ne correspondent pas');
                    return;
                }
                if (newPassword.length < 8) {
                    alert('Le nouveau mot de passe doit contenir au moins 8 caractères');
                    return;
                }
            }

            // Préparation des données
            const formData = new FormData(profileForm);
            const photoInput = document.getElementById('photoInput');
            if (photoInput.files[0]) {
                formData.append('profilePhoto', photoInput.files[0]);
            }

            // UI Feedback
            const submitBtn = profileForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Enregistrement...';

            // Envoi AJAX
            fetch('index.php?url=profil/update', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;

                if (data.success) {
                    // Message de succès stylisé
                    const successMsg = document.createElement('div');
                    successMsg.style.cssText = `position: fixed; top: 20px; right: 20px; background: linear-gradient(135deg, #4caf50 0%, #45a049 100%); color: white; padding: 20px 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3); z-index: 1000; font-weight: bold; font-size: 1.1rem; animation: slideIn 0.3s ease;`;
                    successMsg.textContent = '✓ Profil mis à jour avec succès !';
                    document.body.appendChild(successMsg);
                    setTimeout(() => successMsg.remove(), 3000);
                    
                    // Reset champs password
                    document.getElementById('currentPassword').value = '';
                    document.getElementById('newPassword').value = '';
                    document.getElementById('confirmPassword').value = '';
                    document.getElementById('passwordStrength').style.display = 'none';
                    document.getElementById('passwordMatchMessage').style.display = 'none';
                    
                } else {
                    alert('Erreur : ' + (data.message || 'Une erreur est survenue'));
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                alert('Une erreur est survenue.');
            });
        });

        // Modales de suppression
        window.showDeleteModal = function() {
            if (document.getElementById('deleteModal')) return;
            const overlay = document.createElement('div');
            overlay.id = 'deleteModal';
            overlay.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center; z-index: 2000;';
            overlay.innerHTML = '<div style="background: white; padding: 40px; border-radius: 12px; width: 90%; max-width: 450px; text-align: center; box-shadow: 0 10px 50px rgba(0,0,0,0.3);"><h2 style="margin: 0 0 20px 0; color: #333;">Supprimer votre compte ?</h2><p style="color: #666; margin: 15px 0;">Cette action est irréversible.</p><div style="margin-top: 30px; display: flex; gap: 10px; justify-content: center;"><button onclick="document.getElementById(\'deleteModal\').remove();" style="padding: 10px 25px; background: #ccc; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Annuler</button><button onclick="confirmDeleteAccount(); document.getElementById(\'deleteModal\').remove();" style="padding: 10px 25px; background: #a67c52; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Supprimer</button></div></div>';
            document.body.appendChild(overlay);
        };

        window.confirmDeleteAccount = function() {
            const password = prompt('Veuillez entrer votre mot de passe pour confirmer la suppression :');
            if (!password) return;

            fetch('index.php?url=profil/delete', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ password: password })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Votre compte a été supprimé');
                    window.location.href = 'index.php?url=home';
                } else {
                    alert('Erreur : ' + (data.message || 'Mot de passe incorrect'));
                }
            });
        };

        // UI : Empêcher "Entrée" de valider le form sauf textarea
        profileForm.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA') {
                e.preventDefault();
            }
        });
    });
    </script>
</body>
</html>