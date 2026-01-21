<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Culturia</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <style>
        .profile-simple-container {
            max-width: 800px;
            margin: 60px auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .profile-simple-header {
            text-align: center;
            padding-bottom: 30px;
            border-bottom: 2px solid #E8DFD5;
            margin-bottom: 30px;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #C89B7B 0%, #B88A6A 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            font-weight: bold;
            color: white;
            margin: 0 auto 20px;
            border: 4px solid #E8DFD5;
        }

        .profile-simple-header h1 {
            font-size: 32px;
            color: #333;
            margin-bottom: 10px;
        }

        .profile-simple-header p {
            color: #666;
            font-size: 16px;
        }

        .profile-info-grid {
            display: grid;
            gap: 25px;
            margin-bottom: 40px;
        }

        .profile-info-item {
            background-color: #F9F7F4;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #C89B7B;
        }

        .profile-info-item label {
            display: block;
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .profile-info-item .value {
            font-size: 18px;
            color: #333;
            font-weight: 500;
        }

        .profile-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-profile {
            padding: 15px 30px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background-color: #C89B7B;
            color: #3A2A1A;
        }

        .btn-primary:hover {
            background-color: #B88A6A;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary {
            background-color: #E8DFD5;
            color: #3A2A1A;
        }

        .btn-secondary:hover {
            background-color: #D9CFC0;
            transform: translateY(-2px);
        }

        .btn-danger {
            background-color: #D4A5A5;
            color: #8B4747;
        }

        .btn-danger:hover {
            background-color: #C89B9B;
            transform: translateY(-2px);
        }

        .success-message {
            background-color: #A5D4A5;
            color: #2F5A2F;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 25px;
            animation: slideDown 0.5s ease-out;
        }

        .error-message {
            background-color: #D4A5A5;
            color: #8B4747;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            animation: slideDown 0.5s ease-out;
        }

        .error-message ul {
            margin: 0;
            padding-left: 20px;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .profile-simple-container {
                margin: 20px;
                padding: 20px;
            }

            .profile-actions {
                flex-direction: column;
            }

            .btn-profile {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <?php
    
    // Créer les initiales pour l'avatar
    $initials = strtoupper(substr($user['username'], 0, 2));
    
    // Formater la date d'inscription
    $createdDate = new DateTime($user['created_at']);
    $memberSince = $createdDate->format('d/m/Y');
    ?>

    <div class="profile-simple-container">
        <!-- Messages -->
        <?php if (!empty($success)): ?>
            <div class="success-message">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- En-tête du profil -->
        <div class="profile-simple-header">
            <div class="profile-avatar">
                <?= $initials ?>
            </div>
            <h1>Mon Profil</h1>
            <p>Bienvenue, <?= htmlspecialchars($user['username']) ?> !</p>
        </div>

        <!-- Informations du profil -->
        <div class="profile-info-grid">
            <div class="profile-info-item">
                <label> Nom d'utilisateur</label>
                <div class="value"><?= htmlspecialchars($user['username']) ?></div>
            </div>

            <div class="profile-info-item">
                <label> Adresse email</label>
                <div class="value"><?= htmlspecialchars($user['email']) ?></div>
            </div>

            <div class="profile-info-item">
                <label> Membre depuis</label>
                <div class="value"><?= htmlspecialchars($memberSince) ?></div>
            </div>
        </div>

        <!-- Actions -->
        <div class="profile-actions">
            <a href="index.php?url=modifProfil" class="btn-profile btn-primary">
                 Modifier mon profil
            </a>
            <a href="index.php?url=home" class="btn-profile btn-secondary">
                 Retour à l'accueil
            </a>
            <a href="index.php?url=logout" class="btn-profile btn-danger" 
               onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?')">
                 Déconnexion
            </a>
        </div>
    </div>
    <script src="../public/assets/js/register.js"></script>
</body>
</html>