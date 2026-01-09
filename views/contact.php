<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactez-nous - Culturia</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <?php

        require_once __DIR__ . '/header.html';

    ?>
    
    <div class="contact-container">
        <div class="contact-header">
            <h1>Contactez-nous</h1>
            <p>Nous sommes à votre écoute pour répondre à toutes vos questions</p>
        </div>

        <div class="contact-content">
            <!-- Informations de contact -->
            <div class="contact-info">
                <h2>Nos coordonnées</h2>

                <div class="info-item">
                    <div class="info-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </div>
                    <div class="info-content">
                        <h3>Adresse</h3>
                        <p>123 Rue de l'Art<br>75001 Paris, France</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </div>
                    <div class="info-content">
                        <h3>Email</h3>
                        <p><a href="mailto:contact@culturia.fr">contact@culturia.fr</a></p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                    </div>
                    <div class="info-content">
                        <h3>Téléphone</h3>
                        <p><a href="tel:+33123456789">+33 1 23 45 67 89</a></p>
                        <p style="font-size: 0.9em; margin-top: 5px; color: #7a7265;">Lun - Ven : 9h - 18h</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    </div>
                    <div class="info-content">
                        <h3>Horaires d'ouverture</h3>
                        <p>Lundi - Vendredi : 9h00 - 18h00<br>
                        Samedi : 10h00 - 16h00<br>
                        Dimanche : Fermé</p>
                    </div>
                </div>

                <div style="margin-top: 20px;">
                    <h3 style="color: #3a3226; margin-bottom: 15px;">Suivez-nous</h3>
                    <div class="social-links">
                        <a href="#" class="social-link" aria-label="Instagram">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465.66.254 1.216.598 1.772 1.153.509.5.902 1.105 1.153 1.772.247.637.415 1.363.465 2.428.047 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.218 1.79-.465 2.428a4.883 4.883 0 0 1-1.153 1.772c-.5.508-1.105.902-1.772 1.153-.637.247-1.363.415-2.428.465-1.066.047-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.218-2.428-.465a4.89 4.89 0 0 1-1.772-1.153 4.904 4.904 0 0 1-1.153-1.772c-.248-.637-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.066.217-1.79.465-2.428a4.88 4.88 0 0 1 1.153-1.772A4.897 4.897 0 0 1 5.45 2.525c.638-.248 1.362-.415 2.428-.465C8.944 2.013 9.283 2 12 2zm0 5a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm6.5-.25a1.25 1.25 0 0 0-2.5 0 1.25 1.25 0 0 0 2.5 0zM12 9a3 3 0 1 1 0 6 3 3 0 0 1 0-6z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="Facebook">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="Twitter/X">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="LinkedIn">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Formulaire de contact -->
            <div class="contact-form-section">
                <h2>Envoyez-nous un message</h2>
                <form id="contactForm" class="contact-form">
                    <div class="form-group">
                        <label for="name">Nom complet <span class="required">*</span></label>
                        <input type="text" id="name" name="name" placeholder="Jean Dupont" required>
                        <span class="error-message">Veuillez entrer votre nom</span>
                    </div>

                    <div class="form-group">
                        <label for="email">Email <span class="required">*</span></label>
                        <input type="email" id="email" name="email" placeholder="jean.dupont@email.com" required>
                        <span class="error-message">Veuillez entrer un email valide</span>
                    </div>

                    <div class="form-group">
                        <label for="phone">Téléphone</label>
                        <input type="tel" id="phone" name="phone" placeholder="+33 6 12 34 56 78">
                    </div>

                    <div class="form-group">
                        <label for="subject">Sujet <span class="required">*</span></label>
                        <select id="subject" name="subject" required>
                            <option value="">Sélectionnez un sujet</option>
                            <option value="info">Demande d'information</option>
                            <option value="achat">Question sur un achat</option>
                            <option value="artiste">Devenir artiste</option>
                            <option value="livraison">Problème de livraison</option>
                            <option value="technique">Support technique</option>
                            <option value="autre">Autre</option>
                        </select>
                        <span class="error-message">Veuillez sélectionner un sujet</span>
                    </div>

                    <div class="form-group">
                        <label for="message">Message <span class="required">*</span></label>
                        <textarea id="message" name="message" placeholder="Décrivez votre demande en détail..." required></textarea>
                        <span class="error-message">Veuillez entrer un message</span>
                    </div>

                    <button type="submit" class="submit-btn">Envoyer le message</button>

                    <div id="successMessage" class="success-message">
                        ✓ Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Gestion du formulaire de contact
        const contactForm = document.getElementById('contactForm');
        const successMessage = document.getElementById('successMessage');

        // Fonction de validation email
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // Fonction de validation du formulaire
        function validateForm() {
            let isValid = true;
            const formGroups = contactForm.querySelectorAll('.form-group');

            formGroups.forEach(group => {
                const input = group.querySelector('input, textarea, select');
                if (!input) return;

                // Réinitialiser l'état d'erreur
                group.classList.remove('error');

                // Vérifier les champs requis
                if (input.hasAttribute('required')) {
                    if (input.value.trim() === '') {
                        group.classList.add('error');
                        isValid = false;
                    } else if (input.type === 'email' && !isValidEmail(input.value)) {
                        group.classList.add('error');
                        isValid = false;
                    }
                }
            });

            return isValid;
        }

        // Validation en temps réel
        contactForm.querySelectorAll('input, textarea, select').forEach(field => {
            field.addEventListener('blur', function() {
                const formGroup = this.closest('.form-group');
                formGroup.classList.remove('error');

                if (this.hasAttribute('required') && this.value.trim() === '') {
                    formGroup.classList.add('error');
                } else if (this.type === 'email' && this.value.trim() !== '' && !isValidEmail(this.value)) {
                    formGroup.classList.add('error');
                }
            });

            // Supprimer l'erreur lors de la saisie
            field.addEventListener('input', function() {
                const formGroup = this.closest('.form-group');
                if (this.value.trim() !== '') {
                    formGroup.classList.remove('error');
                }
            });
        });

        // Soumission du formulaire
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();

            if (!validateForm()) {
                const firstError = contactForm.querySelector('.form-group.error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return;
            }

            const submitBtn = contactForm.querySelector('.submit-btn');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Envoi en cours...';

            // Préparer les données du formulaire
            const formData = new FormData(contactForm);

            // Envoyer via fetch
            fetch('index.php?url=contact/send', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Envoyer le message';

                if (data.success) {
                    // Réinitialiser le formulaire
                    contactForm.reset();

                    // Afficher le message de succès
                    successMessage.textContent = data.message;
                    successMessage.classList.add('show');

                    // Masquer après 5 secondes
                    setTimeout(() => {
                        successMessage.classList.remove('show');
                    }, 5000);

                    successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    // Afficher les erreurs
                    if (data.errors) {
                        Object.keys(data.errors).forEach(fieldName => {
                            const formGroup = contactForm.querySelector(`[name="${fieldName}"]`)?.closest('.form-group');
                            if (formGroup) {
                                formGroup.classList.add('error');
                                const errorMsg = formGroup.querySelector('.error-message');
                                if (errorMsg) {
                                    errorMsg.textContent = data.errors[fieldName];
                                }
                            }
                        });
                    } else {
                        alert(data.message || 'Une erreur est survenue');
                    }
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                submitBtn.disabled = false;
                submitBtn.textContent = 'Envoyer le message';
                alert('Une erreur est survenue lors de l\'envoi du message');
            });
        });
    </script>
    <?php
    require_once __DIR__ . '/footer.html';
    ?>
</body>
</html>