// public/assets/js/register.js
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('registerForm');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        const password = document.getElementById('password').value;
        const confirm  = document.getElementById('confirm_password').value;
        const email    = document.getElementById('email').value.trim();

        let messages = [];

        if (!email.includes('@')) {
            messages.push("Email invalide.");
        }

        if (password.length < 8) {
            messages.push("Mot de passe trop court (min 8 caractères).");
        }

        if (password !== confirm) {
            messages.push("Les mots de passe ne correspondent pas.");
        }

        if (messages.length > 0) {
            e.preventDefault();
            alert(messages.join("\n"));
        }
    });
});
