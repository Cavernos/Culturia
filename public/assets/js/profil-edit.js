// public/assets/js/profil-edit.js
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form[action*="updateProfil"]');
    if (!form) return;

    const usernameInput = document.getElementById('username');
    const emailInput = document.getElementById('email');
    const currentPasswordInput = document.getElementById('current_password');
    const newPasswordInput = document.getElementById('new_password');
    const confirmPasswordInput = document.getElementById('confirm_password');

    // Fonction pour créer un message d'erreur
    function createErrorMessage(inputElement, message) {
        removeErrorMessage(inputElement);

        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message-inline';
        errorDiv.textContent = message;
        errorDiv.style.color = '#8B4747';
        errorDiv.style.backgroundColor = '#FFE5E5';
        errorDiv.style.fontSize = '13px';
        errorDiv.style.padding = '8px 12px';
        errorDiv.style.borderRadius = '5px';
        errorDiv.style.marginTop = '8px';
        errorDiv.style.borderLeft = '3px solid #D4A5A5';

        inputElement.classList.add('input-error-edit');
        inputElement.parentElement.appendChild(errorDiv);
    }

    // Fonction pour supprimer un message d'erreur
    function removeErrorMessage(inputElement) {
        const errorDiv = inputElement.parentElement.querySelector('.error-message-inline');
        if (errorDiv) {
            errorDiv.remove();
        }
        inputElement.classList.remove('input-error-edit');
        inputElement.classList.remove('input-success-edit');
    }

    // Fonction pour marquer un champ comme valide
    function markAsValid(inputElement) {
        removeErrorMessage(inputElement);
        inputElement.classList.add('input-success-edit');
    }

    // Validation du nom d'utilisateur
    function validateUsername() {
        const username = usernameInput.value.trim();

        if (username === '') {
            createErrorMessage(usernameInput, 'Le nom d\'utilisateur est obligatoire.');
            return false;
        }

        if (username.length < 3) {
            createErrorMessage(usernameInput, 'Nom d\'utilisateur trop court (minimum 3 caractères).');
            return false;
        }

        markAsValid(usernameInput);
        return true;
    }

    // Validation de l'email
    function validateEmail() {
        const email = emailInput.value.trim();

        if (email === '') {
            createErrorMessage(emailInput, 'L\'email est obligatoire.');
            return false;
        }

        if (!email.includes('@') || !email.includes('.')) {
            createErrorMessage(emailInput, 'Email invalide. Format attendu : exemple@mail.com');
            return false;
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            createErrorMessage(emailInput, 'Format d\'email invalide.');
            return false;
        }

        markAsValid(emailInput);
        return true;
    }

    // Validation des mots de passe
    function validatePasswords() {
        const currentPassword = currentPasswordInput.value;
        const newPassword = newPasswordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        // Si aucun champ de mot de passe n'est rempli, pas de validation
        if (!currentPassword && !newPassword && !confirmPassword) {
            removeErrorMessage(currentPasswordInput);
            removeErrorMessage(newPasswordInput);
            removeErrorMessage(confirmPasswordInput);
            return true;
        }

        let isValid = true;

        // Si on veut changer le mot de passe
        if (newPassword || confirmPassword || currentPassword) {
            // Vérifier que le mot de passe actuel est rempli
            if (!currentPassword) {
                createErrorMessage(currentPasswordInput, 'Veuillez saisir votre mot de passe actuel.');
                isValid = false;
            } else {
                markAsValid(currentPasswordInput);
            }

            // Vérifier le nouveau mot de passe
            if (!newPassword) {
                createErrorMessage(newPasswordInput, 'Veuillez saisir un nouveau mot de passe.');
                isValid = false;
            } else if (newPassword.length < 8) {
                createErrorMessage(newPasswordInput, 'Le nouveau mot de passe doit contenir au moins 8 caractères.');
                isValid = false;
            } else {
                // Vérifications supplémentaires
                const hasLetter = /[a-zA-Z]/.test(newPassword);
                const hasNumber = /[0-9]/.test(newPassword);

                if (!hasLetter || !hasNumber) {
                    createErrorMessage(newPasswordInput, 'Le mot de passe doit contenir au moins une lettre et un chiffre.');
                    isValid = false;
                } else {
                    markAsValid(newPasswordInput);
                }
            }

            // Vérifier la confirmation
            if (!confirmPassword) {
                createErrorMessage(confirmPasswordInput, 'Veuillez confirmer le nouveau mot de passe.');
                isValid = false;
            } else if (newPassword !== confirmPassword) {
                createErrorMessage(confirmPasswordInput, 'Les mots de passe ne correspondent pas.');
                isValid = false;
            } else {
                markAsValid(confirmPasswordInput);
            }
        }

        return isValid;
    }

    // Événements de validation en temps réel
    usernameInput.addEventListener('blur', validateUsername);
    usernameInput.addEventListener('input', () => {
        if (usernameInput.value.trim() !== '') {
            validateUsername();
        }
    });

    emailInput.addEventListener('blur', validateEmail);
    emailInput.addEventListener('input', () => {
        if (emailInput.value.trim() !== '') {
            validateEmail();
        }
    });

    // Validation des mots de passe au blur
    currentPasswordInput.addEventListener('blur', validatePasswords);
    newPasswordInput.addEventListener('blur', validatePasswords);
    confirmPasswordInput.addEventListener('blur', validatePasswords);

    // Validation en temps réel pour les mots de passe
    currentPasswordInput.addEventListener('input', () => {
        if (currentPasswordInput.value || newPasswordInput.value || confirmPasswordInput.value) {
            validatePasswords();
        }
    });

    newPasswordInput.addEventListener('input', () => {
        if (newPasswordInput.value !== '') {
            validatePasswords();
        }
    });

    confirmPasswordInput.addEventListener('input', () => {
        if (confirmPasswordInput.value !== '') {
            validatePasswords();
        }
    });

    // Validation complète lors de la soumission
    form.addEventListener('submit', function (e) {
        // Valider tous les champs obligatoires
        const isUsernameValid = validateUsername();
        const isEmailValid = validateEmail();
        const arePasswordsValid = validatePasswords();

        // Si au moins un champ est invalide, empêche la soumission
        if (!isUsernameValid || !isEmailValid || !arePasswordsValid) {
            e.preventDefault();

            // Scroll vers le premier champ en erreur
            const firstError = form.querySelector('.input-error-edit');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }

            // Afficher un message d'alerte
            alert('Veuillez corriger les erreurs dans le formulaire avant de soumettre.');
        }
    });
});