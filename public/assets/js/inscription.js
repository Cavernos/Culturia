document.addEventListener("DOMContentLoaded", () => {
  const password = document.getElementById("password");
  const bar = document.getElementById("passwordStrengthBar");
  const text = document.getElementById("passwordStrengthText");

  if (!password || !bar || !text) return;

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

  function reset() {
    bar.classList.remove("is-weak", "is-medium", "is-strong");
    text.classList.remove("is-weak", "is-medium", "is-strong");
  }

  function updateStrength() {
    const pw = password.value;
    const score = scorePassword(pw);

    reset();

    if (pw.length === 0) {
      bar.style.width = "0%";
      text.textContent = "";
      return;
    }

    if (score <= 2) {
      bar.classList.add("is-weak");
      text.classList.add("is-weak");
      bar.style.width = "33%";
      text.textContent = "Mot de passe faible.";
    } else if (score <= 4) {
      bar.classList.add("is-medium");
      text.classList.add("is-medium");
      bar.style.width = "66%";
      text.textContent = "Mot de passe moyen.";
    } else {
      bar.classList.add("is-strong");
      text.classList.add("is-strong");
      bar.style.width = "100%";
      text.textContent = "Mot de passe fort.";
    }
  }

  password.addEventListener("input", updateStrength);
  updateStrength(); // au cas où le navigateur remplit automatiquement
});
