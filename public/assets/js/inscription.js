document.addEventListener("DOMContentLoaded", () => {
  const password = document.getElementById("password");
  const confirmPassword = document.getElementById("password_confirmation");
  const bar = document.getElementById("passwordStrengthBar");
  const strengthText = document.getElementById("passwordStrengthText");

  const email = document.getElementById("email");
  const emailHelp = document.getElementById("emailHelp");

  
  if (!password || !bar || !strengthText) return;

  function scorePassword(pw) {
    let score = 0;
    if (!pw) return 0;

    if (pw.length >= 8) score += 1;
    if (pw.length >= 12) score += 1;
    if (/[a-z]/.test(pw)) score += 1;
    if (/[A-Z]/.test(pw)) score += 1;
    if (/[0-9]/.test(pw)) score += 1;
    if (/[^A-Za-z0-9]/.test(pw)) score += 1;

    return score; // 0..6
  }

  function resetStrength() {
    bar.classList.remove("is-weak", "is-medium", "is-strong");
    strengthText.classList.remove("is-weak", "is-medium", "is-strong");
  }

  function updateStrength() {
    const pw = password.value;
    const score = scorePassword(pw);

    resetStrength();

    if (pw.length === 0) {
      bar.style.width = "0%";
      strengthText.textContent = "";
      return;
    }

    if (score <= 2) {
      bar.classList.add("is-weak");
      strengthText.classList.add("is-weak");
      bar.style.width = "33%";
      strengthText.textContent = "Mot de passe faible.";
    } else if (score <= 4) {
      bar.classList.add("is-medium");
      strengthText.classList.add("is-medium");
      bar.style.width = "66%";
      strengthText.textContent = "Mot de passe moyen.";
    } else {
      bar.classList.add("is-strong");
      strengthText.classList.add("is-strong");
      bar.style.width = "100%";
      strengthText.textContent = "Mot de passe fort.";
    }
  }

  function updateEmailValidity() {
    if (!email || !emailHelp) return;

    const v = email.value.trim();

    email.classList.remove("is-valid", "is-invalid");
    emailHelp.classList.remove("is-valid", "is-invalid");
    emailHelp.textContent = "";

    if (v.length === 0) return;

   
    const ok = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);

    if (ok) {
      email.classList.add("is-valid");
      emailHelp.classList.add("is-valid");
      emailHelp.textContent = "Email valide";
    } else {
      email.classList.add("is-invalid");
      emailHelp.classList.add("is-invalid");
      emailHelp.textContent = "Format d’email invalide.";
    }
  }

  function updatePasswordMatch() {
    if (!confirmPassword) return;

    confirmPassword.classList.remove("is-valid", "is-invalid");

    if (confirmPassword.value.length === 0) return;

    if (confirmPassword.value === password.value) {
      confirmPassword.classList.add("is-valid");
    } else {
      confirmPassword.classList.add("is-invalid");
    }
  }

  password.addEventListener("input", () => {
    updateStrength();
    updatePasswordMatch();
  });

  if (confirmPassword) {
    confirmPassword.addEventListener("input", updatePasswordMatch);
  }

  if (email) {
    email.addEventListener("input", updateEmailValidity);
    updateEmailValidity();
  }

  updateStrength();
});
