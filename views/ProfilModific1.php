<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier mon profil - Culturia</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <style>
        .edit-profile-container {
            max-width: 600px;
            margin: 60px auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .edit-profile-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .edit-profile-header h1 {
            font-size: 32px;
            color: #333;
            margin-bottom: 10px;
        }

        .edit-profile-header p {
            color: #666;
            font-size: 16px;
        }

        .form-group-edit {
            margin-bottom: 25px;
        }

        .form-group-edit label {
            display: block;
            font-size: 16px;
            color: #333;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-group-edit input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #E8DFD5;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s;
        }

        .form-group-edit input:focus {
            outline: none;
            border-color: #C89B7B;
            box-shadow: 0 0 0 3px rgba(200, 155, 123, 0.1);
        }

        .form-group-edit .helper {
            font-size: 13px;
            color: #666;
            margin-top: 6px;
        }

        .button-group-edit {
            display: flex;
            gap: 15px;
            margin-top: 40px;
        }

        .btn-edit {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }

        .btn-save {
            background-color: #C89B7B;
            color: #3A2A1A;
        }

        .btn-save:hover {
            background-color: #B88A6A;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-cancel {
            background-color: #E8DFD5;
            color: #3A2A1A;
        }

        .btn-cancel:hover {
            background-color: #D9CFC0;
            transform: translateY(-2px);
        }

        .error-message-edit {
            background-color: #D4A5A5;
            color: #8B4747;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .error-message-edit ul {
            margin: 0;
            padding-left: 20px;
        }

        .password-section {
            margin-top: 40px;
            padding-top: 40px;
            border-top: 2px solid #E8DFD5;
        }

        .password-section h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .edit-profile-container {
                margin: 20px;
                padding: 20px;
            }

            .button-group-edit {
                flex-direction: column;
            }
        }
        /* Styles pour la validation en temps réel */
        .input-error-edit {
            border-color: #D4A5A5 !important;
            background-color: #FFF8F8 !important;
        }

        .input-success-edit {
            border-color: #A5D4A5 !important;
            background-color: #F8FFF8 !important;
        }

        .input-error-edit:focus {
            border-color: #D4A5A5 !important;
            box-shadow: 0 0 0 3px rgba(212, 165, 165, 0.1);
        }

        .input-success-edit:focus {
            border-color: #A5D4A5 !important;
            box-shadow: 0 0 0 3px rgba(165, 212, 165, 0.1);
        }

        /* Message d'erreur inline */
        .error-message-inline {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Icônes visuelles */
        .input-success-edit {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23A5D4A5'%3E%3Cpath d='M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            padding-right: 40px;
        }

        .input-error-edit {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23D4A5A5'%3E%3Cpath d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/%3E%3Cpath d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            padding-right: 40px;
        }
    </style>
</head>
<body>
    <?php
    // Variables disponibles depuis le contrôleur :
    // $user = ['id', 'username', 'email', 'created_at']
    // $errors = tableau d'erreurs
    // $old = anciennes valeurs en cas d'erreur
    // $_SESSION['csrf_token'] = token CSRF
    ?>

    <div class="edit-profile-container">
        <div class="edit-profile-header">
            <h1>Modifier mon profil</h1>
            <p>Mettez à jour vos informations personnelles</p>
        </div>

        <!-- Messages d'erreur -->
        <?php if (!empty($errors)): ?>
            <div class="error-message-edit">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="index.php?url=updateProfil" method="post">
            <!-- Token CSRF -->
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

            <!-- Nom d'utilisateur -->
            <div class="form-group-edit">
                <label for="username">Nom d'utilisateur *</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    value="<?= htmlspecialchars($old['username'] ?? $user['username']) ?>"
                    required
                    minlength="3"
                >
                <p class="helper">Minimum 3 caractères</p>
            </div>

            <!-- Email -->
            <div class="form-group-edit">
                <label for="email">Adresse email *</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="<?= htmlspecialchars($old['email'] ?? $user['email']) ?>"
                    required
                >
            </div>

            <!-- Section changement de mot de passe -->
            <div class="password-section">
                <h2>Changer le mot de passe</h2>
                <p style="color: #666; margin-bottom: 20px;">
                    Laissez ces champs vides si vous ne souhaitez pas changer votre mot de passe.
                </p>

                <div class="form-group-edit">
                    <label for="current_password">Mot de passe actuel</label>
                    <input 
                        type="password" 
                        id="current_password" 
                        name="current_password"
                    >
                </div>

                <div class="form-group-edit">
                    <label for="new_password">Nouveau mot de passe</label>
                    <input 
                        type="password" 
                        id="new_password" 
                        name="new_password"
                        minlength="8"
                    >
                    <p class="helper">Minimum 8 caractères</p>
                </div>

                <div class="form-group-edit">
                    <label for="confirm_password">Confirmer le nouveau mot de passe</label>
                    <input 
                        type="password" 
                        id="confirm_password" 
                        name="confirm_password"
                        minlength="8"
                    >
                </div>
            </div>

            <!-- Boutons -->
            <div class="button-group-edit">
                <a href="index.php?url=profil" class="btn-edit btn-cancel">
                     Annuler
                </a>
                <button type="submit" class="btn-edit btn-save">
                     Enregistrer
                </button>
            </div>
        </form>
    </div>

    <script src="../public/assets/js/profil-edit.js"></script>
</body>
</html>