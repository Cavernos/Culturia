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
                from {
                    transform: translateX(400px);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
        </style>
    </head>
    <body>
        <?php include 'header.html'; ?>
        
        <!-- Main Content -->
        <div class="Profilcontainer">
            <h1 class="page-title">Modifier mon profil</h1>
            
            <div class="profile-header">
                <div class="profile-photo-container">
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='150' height='150'%3E%3Ccircle cx='75' cy='75' r='75' fill='%23a67c52'/%3E%3Ctext x='50%25' y='50%25' text-anchor='middle' dy='.3em' fill='white' font-size='60' font-family='Georgia'%3EDD%3C/text%3E%3C/svg%3E" alt="Photo de profil" class="profile-photo" id="profilePhoto">
                    <button type="button" class="photo-upload-btn" onclick="document.getElementById('photoInput').click()">
                        +
                        <input type="file" id="photoInput" accept="image/*" onchange="updateProfilePhoto(event)">
                    </button>
                </div>
            </div>

            <form id="profileForm">
                <!-- Informations personnelles -->
                <h2 class="section-title">Informations personnelles</h2>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="firstName">Prénom <span class="required">*</span></label>
                        <input type="text" id="firstName" name="firstName" value="Diogo" required>
                    </div>

                    <div class="form-group">
                        <label for="lastName">Nom <span class="required">*</span></label>
                        <input type="text" id="lastName" name="lastName" value="Da costa" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="username">Nom d'utilisateur <span class="required">*</span></label>
                    <input type="text" id="username" name="username" value="Diogo_art" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email <span class="required">*</span></label>
                        <input type="email" id="email" name="email" value="diogodacosta@exemple.fr" readonly style="background-color: #f5f5f5; cursor: not-allowed; color: #999;">
                        <small style="color: #a67c52; font-style: italic;">Ce champ ne peut pas être modifié</small>
                    </div>

                    <div class="form-group">
                        <label for="phone">Téléphone</label>
                        <input type="tel" id="phone" name="phone" value="+33 6 12 34 56 78" placeholder="+33 6 12 34 56 78" onchange="validatePhone()">
                        <small id="phoneError" style="color: #ff4444; display: none;">Format invalide. Utilisez le format: +33 6 12 34 56 78</small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="bio">Biographie</label>
                    <textarea id="bio" name="bio" placeholder="Parlez-nous de vous, votre parcours artistique, vos inspirations...">Artiste peintre passionné par l'art classique et contemporain. Je crée des œuvres qui fusionnent techniques traditionnelles et vision moderne.</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="city">Ville</label>
                        <input type="text" id="city" name="city" value="Paris">
                    </div>

                    <div class="form-group">
                        <label for="country">Pays</label>
                        <input type="text" id="country" name="country" value="France">
                    </div>
                </div>

                <!-- Informations artistiques -->
                <h2 class="section-title">Informations artistiques</h2>

                <div class="form-group">
                    <label for="artistType">Type d'artiste</label>
                    <select id="artistType" name="artistType">
                        <option value="peintre" selected>Peintre</option>
                        <option value="sculpteur">Sculpteur</option>
                        <option value="photographe">Photographe</option>
                        <option value="illustrateur">Illustrateur</option>
                        <option value="ceramiste">Céramiste</option>
                        <option value="mixte">Art mixte</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="specialties">Spécialités (séparées par des virgules)</label>
                    <input type="text" id="specialties" name="specialties" value="Huile sur toile, Aquarelle, Portrait">
                </div>

                <div class="form-group">
                    <label for="experience">Années d'expérience</label>
                    <input type="text" id="experience" name="experience" value="8 ans">
                </div>

                <!-- Réseaux sociaux -->
                <h2 class="section-title">Réseaux sociaux & Site web</h2>

                <div class="social-links">
                    <div class="form-group">
                        <label for="website">Site web personnel</label>
                        <input type="url" id="website" name="website" placeholder="https://">
                    </div>

                    <div class="form-group">
                        <label for="instagram">Instagram</label>
                        <input type="text" id="instagram" name="instagram" placeholder="@votre_compte">
                    </div>

                    <div class="form-group">
                        <label for="facebook">Facebook</label>
                        <input type="url" id="facebook" name="facebook" placeholder="https://facebook.com/...">
                    </div>

                    <div class="form-group">
                        <label for="twitter">Twitter / X</label>
                        <input type="text" id="twitter" name="twitter" placeholder="@votre_compte">
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
        // Profile Edit JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            const profileForm = document.getElementById('profileForm');
            const newPasswordInput = document.getElementById('newPassword');
            const confirmPasswordInput = document.getElementById('confirmPassword');
            const currentPasswordInput = document.getElementById('currentPassword');

            // Gestion de la soumission du formulaire
            profileForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Afficher le message de succès
                showSuccessMessage();
                
                // Rediriger vers la page profil après 2 secondes
                setTimeout(function() {
                    window.location.href = '?url=profil';
                }, 2000);
            });

            // Fonction pour afficher le message de succès
            window.showSuccessMessage = function() {
                // Créer le message de succès
                const successMsg = document.createElement('div');
                successMsg.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
                    color: white;
                    padding: 20px 30px;
                    border-radius: 8px;
                    box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
                    z-index: 1000;
                    font-weight: bold;
                    font-size: 1.1rem;
                    animation: slideIn 0.3s ease;
                `;
                successMsg.textContent = '✓ Profil enregistré avec succès !';
                document.body.appendChild(successMsg);
            };

            // Mise à jour de la photo de profil
            window.updateProfilePhoto = function(event) {
                const file = event.target.files[0];
                if (file) {


                    // Vérifier le type
                    if (!file.type.startsWith('image/')) {
                        alert('Veuillez sélectionner une image valide');
                        event.target.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Afficher l'image dans le formulaire
                        document.getElementById('profilePhoto').src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            };

            // Validation de la force du mot de passe
            function checkPasswordStrength(password) {
                let strength = 0;
                if (password.length >= 8) strength++;
                if (password.length >= 12) strength++;
                if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
                if (/\d/.test(password)) strength++;
                if (/[^a-zA-Z\d]/.test(password)) strength++;

                return strength;
            }

            // Validation du numéro de téléphone
            window.validatePhone = function() {
                const phone = document.getElementById('phone').value;
                const phoneError = document.getElementById('phoneError');
                
                // Format accepté: +33 6 12 34 56 78 ou variations
                const phoneRegex = /^(\+33|0)[1-9](\s?\d{2}){4}$|^\+33\s?[1-9](\s?\d{2}){4}$/;
                
                if (phone && !phoneRegex.test(phone.replace(/\s/g, ''))) {
                    phoneError.style.display = 'block';
                    document.getElementById('phone').style.borderColor = '#ff4444';
                } else {
                    phoneError.style.display = 'none';
                    document.getElementById('phone').style.borderColor = '#ddd';
                }
            };
            // Affichage de la force du mot de passe
            if (newPasswordInput) {
                // Créer l'indicateur de force
                const strengthContainer = document.createElement('div');
                strengthContainer.className = 'password-strength';
                strengthContainer.innerHTML = `
                    <div class="strength-bar">
                        <div class="strength-bar-fill" id="strengthBarFill"></div>
                    </div>
                    <span id="strengthText"></span>
                `;
                newPasswordInput.parentElement.appendChild(strengthContainer);

                newPasswordInput.addEventListener('input', function() {
                    const password = this.value;
                    const strengthBar = document.getElementById('strengthBarFill');
                    const strengthText = document.getElementById('strengthText');

                    if (password.length === 0) {
                        strengthBar.className = 'strength-bar-fill';
                        strengthText.textContent = '';
                        return;
                    }

                    const strength = checkPasswordStrength(password);
                    strengthBar.className = 'strength-bar-fill';

                    if (strength <= 2) {
                        strengthBar.classList.add('strength-weak');
                        strengthText.textContent = 'Mot de passe faible';
                        strengthText.style.color = '#c44';
                    } else if (strength <= 4) {
                        strengthBar.classList.add('strength-medium');
                        strengthText.textContent = 'Mot de passe moyen';
                        strengthText.style.color = '#f90';
                    } else {
                        strengthBar.classList.add('strength-strong');
                        strengthText.textContent = 'Mot de passe fort';
                        strengthText.style.color = '#4c4';
                    }
                });
            }

            // Validation du formulaire
            function validateForm() {
                const errors = [];

                // Validation des champs requis
                const firstName = document.getElementById('firstName').value.trim();
                const lastName = document.getElementById('lastName').value.trim();
                const username = document.getElementById('username').value.trim();
                const email = document.getElementById('email').value.trim();

                if (!firstName) errors.push('Le prénom est requis');
                if (!lastName) errors.push('Le nom est requis');
                if (!username) errors.push('Le nom d\'utilisateur est requis');


                // Validation du mot de passe
                const newPassword = newPasswordInput.value;
                const confirmPassword = confirmPasswordInput.value;
                const currentPassword = currentPasswordInput.value;

                if (newPassword || confirmPassword) {
                    if (!currentPassword) {
                        errors.push('Le mot de passe actuel est requis pour changer de mot de passe');
                    }
                    if (newPassword !== confirmPassword) {
                        errors.push('Les mots de passe ne correspondent pas');
                    }
                    if (newPassword.length > 0 && newPassword.length < 8) {
                        errors.push('Le nouveau mot de passe doit contenir au moins 8 caractères');
                    }
                }

                return errors;
            }

            // Soumission du formulaire
            profileForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Valider le formulaire
                const errors = validateForm();
                if (errors.length > 0) {
                    alert('Erreurs de validation :\n\n' + errors.join('\n'));
                    return;
                }

                // Préparer les données
                const formData = new FormData(profileForm);
                
                // Photo de profil
                const photoInput = document.getElementById('photoInput');
                if (photoInput.files[0]) {
                    formData.append('profilePhoto', photoInput.files[0]);
                }

                // Désactiver le bouton pendant l'envoi
                const submitBtn = profileForm.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                submitBtn.disabled = true;
                submitBtn.textContent = 'Enregistrement...';

                // Envoyer les données
                fetch('index.php?url=profil/update', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;

                    if (data.success) {
                        alert('✓ Profil mis à jour avec succès !');
                        
                        // Réinitialiser les champs de mot de passe
                        currentPasswordInput.value = '';
                        newPasswordInput.value = '';
                        confirmPasswordInput.value = '';
                        
                    } else {
                        alert('Erreur : ' + (data.message || 'Une erreur est survenue'));
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                    alert('Une erreur est survenue lors de la mise à jour du profil');
                });
            });

            // Modal de suppression de compte
            window.showDeleteModal = function() {
                if (document.getElementById('deleteModal')) return;
                
                const overlay = document.createElement('div');
                overlay.id = 'deleteModal';
                overlay.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center; z-index: 2000;';
                
                overlay.innerHTML = '<div style="background: white; padding: 40px; border-radius: 12px; width: 90%; max-width: 450px; text-align: center; box-shadow: 0 10px 50px rgba(0,0,0,0.3);"><h2 style="margin: 0 0 20px 0; color: #333;">Supprimer votre compte ?</h2><p style="color: #666; margin: 15px 0;">Cette action est irréversible. Toutes vos données seront supprimées.</p><p style="color: #666; margin: 15px 0;">Êtes-vous sûr ?</p><div style="margin-top: 30px; display: flex; gap: 10px; justify-content: center;"><button onclick="document.getElementById(\'deleteModal\').remove();" style="padding: 10px 25px; background: #ccc; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Annuler</button><button onclick="confirmDeleteAccount(); document.getElementById(\'deleteModal\').remove();" style="padding: 10px 25px; background: #a67c52; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Supprimer</button></div></div>';
                
                document.body.appendChild(overlay);
            };

            window.closeDeleteModal = function() {
                const modal = document.getElementById('deleteModal');
                if (modal) modal.remove();
            };

            window.confirmDeleteAccount = function() {
                const password = prompt('Veuillez entrer votre mot de passe pour confirmer la suppression :');
                
                if (!password) {
                    return;
                }

                fetch('index.php?url=profil/delete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
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
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue');
                });
            };

            // Validation en temps réel pour les champs
            const inputs = profileForm.querySelectorAll('input[required]');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value.trim() === '') {
                        this.style.borderColor = '#c44';
                    } else {
                        this.style.borderColor = '#e8dfd5';
                    }
                });

                input.addEventListener('input', function() {
                    if (this.value.trim() !== '') {
                        this.style.borderColor = '#e8dfd5';
                    }
                });
            });



            // Empêcher la soumission avec Enter sauf dans textarea
            profileForm.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA') {
                    e.preventDefault();
                }
            });
        });

        // Fonction de vérification de la force du mot de passe
        function checkPasswordStrength() {
            const password = document.getElementById('newPassword').value;
            const strengthDiv = document.getElementById('passwordStrength');
            const strengthBar = document.getElementById('strengthLevel');
            const strengthText = document.getElementById('strengthText');
            const checklist = document.getElementById('passwordChecklist');

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
        </script>
    </body>
    </html>