// public/assets/js/register.js
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('registerForm');
    if (!form) return;

    const emailInput = document.getElementById('email');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('confirm_password');

    // Fonction pour créer un message d'erreur
    function createErrorMessage(inputElement, message) {
        // Supprime l'ancien message d'erreur s'il existe
        removeErrorMessage(inputElement);

        // Crée le nouveau message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.textContent = message;

        // Ajoute une classe d'erreur à l'input
        inputElement.classList.add('input-error');

        // Insère le message après l'input
        inputElement.parentElement.appendChild(errorDiv);
    }

    // Fonction pour supprimer un message d'erreur
    function removeErrorMessage(inputElement) {
        const errorDiv = inputElement.parentElement.querySelector('.error-message');
        if (errorDiv) {
            errorDiv.remove();
        }
        inputElement.classList.remove('input-error');
        inputElement.classList.remove('input-success');
    }

    // Fonction pour marquer un champ comme valide
    function markAsValid(inputElement) {
        removeErrorMessage(inputElement);
        inputElement.classList.add('input-success');
    }

    // Validation de l'email
    function validateEmail() {
        const email = emailInput.value.trim();

        if (email === '') {
            removeErrorMessage(emailInput);
            return false;
        }

        if (!email.includes('@') || !email.includes('.')) {
            createErrorMessage(emailInput, 'Email invalide. Format attendu : exemple@mail.com');
            return false;
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            createErrorMessage(emailInput, 'Email invalide.');
            return false;
        }

        markAsValid(emailInput);
        return true;
    }



    // Validation du nom d'utilisateur
    function validateUsername() {
        const username = usernameInput.value.trim();

        if (username === '') {
            removeErrorMessage(usernameInput);
            return false;
        }

        if (username.length < 3) {
            createErrorMessage(usernameInput, 'Nom d\'utilisateur trop court (minimum 3 caractères).');
            return false;
        }

        markAsValid(usernameInput);
        return true;
    }

    // Validation du mot de passe
    function validatePassword() {
        const password = passwordInput.value;

        if (password === '') {
            removeErrorMessage(passwordInput);
            return false;
        }

        if (password.length < 8) {
            createErrorMessage(passwordInput, 'Mot de passe trop court (minimum 8 caractères).');
            return false;
        }

        // Vérifications supplémentaires optionnelles
        const hasLetter = /[a-zA-Z]/.test(password);
        const hasNumber = /[0-9]/.test(password);

        if (!hasLetter || !hasNumber) {
            createErrorMessage(passwordInput, 'Le mot de passe doit contenir au moins une lettre et un chiffre.');
            return false;
        }

        markAsValid(passwordInput);
        return true;
    }

    // Validation de la confirmation du mot de passe
    function validateConfirmPassword() {
        const password = passwordInput.value;
        const confirm = confirmInput.value;

        if (confirm === '') {
            removeErrorMessage(confirmInput);
            return false;
        }

        if (password !== confirm) {
            createErrorMessage(confirmInput, 'Les mots de passe ne correspondent pas.');
            return false;
        }

        markAsValid(confirmInput);
        return true;
    }

    // Événements de validation en temps réel (lors de la saisie)
    emailInput.addEventListener('blur', validateEmail);
    emailInput.addEventListener('input', () => {
        if (emailInput.value.trim() !== '') {
            validateEmail();
        }
    });

    usernameInput.addEventListener('blur', validateUsername);
    usernameInput.addEventListener('input', () => {
        if (usernameInput.value.trim() !== '') {
            validateUsername();
        }
    });

    passwordInput.addEventListener('blur', validatePassword);
    passwordInput.addEventListener('input', () => {
        if (passwordInput.value !== '') {
            validatePassword();
        }
        // Re-valider la confirmation si elle a déjà été remplie
        if (confirmInput.value !== '') {
            validateConfirmPassword();
        }
    });

    confirmInput.addEventListener('blur', validateConfirmPassword);
    confirmInput.addEventListener('input', () => {
        if (confirmInput.value !== '') {
            validateConfirmPassword();
        }
    });

    // Validation complète lors de la soumission
    form.addEventListener('submit', function (e) {
        // Valide tous les champs
        const isEmailValid = validateEmail();
        const isUsernameValid = validateUsername();
        const isPasswordValid = validatePassword();
        const isConfirmValid = validateConfirmPassword();

        // Si au moins un champ est invalide, empêche la soumission
        if (!isEmailValid || !isUsernameValid || !isPasswordValid || !isConfirmValid) {
            e.preventDefault();

            // Scroll vers le premier champ en erreur
            const firstError = form.querySelector('.input-error');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }
    });
});