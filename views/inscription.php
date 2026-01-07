<?php
declare(strict_types=1);
session_start();

require __DIR__ . "/../config/db.php";

$successMsg = "";
$errorMsg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $email    = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $termsOk  = isset($_POST["terms"]);

    if ($username === "" || $email === "" || $password === "") {
        $errorMsg = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg = "Email invalide.";
    } elseif (strlen($password) < 8) {
        $errorMsg = "Mot de passe trop court (min. 8 caractères).";
    } elseif (!$termsOk) {
        $errorMsg = "Tu dois accepter les conditions d’utilisation.";
    } else {
        $check = $pdo->prepare("SELECT id FROM clients WHERE email = :email LIMIT 1");
        $check->execute(["email" => $email]);

        if ($check->fetch()) {
            $errorMsg = "Un compte existe déjà avec cet email.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("
                INSERT INTO clients (username, email, password, inscription_date, modification_date)
                VALUES (:username, :email, :password, CURDATE(), CURDATE())
            ");
            $stmt->execute([
                "username" => $username,
                "email" => $email,
                "password" => $hash
            ]);

            $successMsg = "Inscription réussie ";
            $_POST = [];
        }
    }
}

function old(string $key): string {
    return htmlspecialchars($_POST[$key] ?? "", ENT_QUOTES, "UTF-8");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Culturia – inscription</title>

  <link rel="stylesheet" href="../public/assets/css/style.css" />
  <link rel="shortcut icon" href="../public/assets/img/favicon.ico" type="image/x-icon" />
</head>

<body>

<main class="main-container inscription-page">

  <div class="inscription-overlay">
    <div class="inscription-modal">

      <h1>S'inscrire</h1>

      <?php if ($errorMsg): ?>
        <p style="color:#b00020; margin-bottom:10px;"><?= htmlspecialchars($errorMsg) ?></p>
      <?php endif; ?>

      <?php if ($successMsg): ?>
        <p style="color:green; margin-bottom:10px;"><?= htmlspecialchars($successMsg) ?></p>
      <?php endif; ?>

      <form class="inscription-form" action="inscription.php" method="POST">

        <div class="form-row">
          <label for="username">Nom :</label>
          <input type="text" id="username" name="username" value="<?= old("username") ?>" required />
        </div>

        <div class="form-row">
          <label for="email">Mail:</label>
          <input type="email" id="email" name="email" value="<?= old("email") ?>" required />
        </div>

        <div class="form-row">
          <label for="password">Mot de passe:</label>
          <input type="password" id="password" name="password" required />
        </div>

        <div class="form-checkbox">
          <input type="checkbox" id="terms" name="terms" <?= isset($_POST["terms"]) ? "checked" : "" ?> required />
          <label for="terms">J’accepte les conditions d’utilisation</label>
        </div>

        <div class="form-actions">
          <button type="submit" class="primary-button">Je m'inscris</button>
        </div>

      </form>
    </div>
  </div>

</main>

</body>
</html>
