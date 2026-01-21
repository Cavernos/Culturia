<?php
// app/Controllers/ProfilController.php
class ProfilController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Affiche la page de profil
     */
    public function index(): void
    {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['errors'] = ["Vous devez être connecté pour accéder à cette page."];
            header('Location: index.php?url=register');
            exit;
        }

        // Récupérer les informations de l'utilisateur
        $user = $this->userModel->findById($_SESSION['user_id']);

        if (!$user) {
            session_destroy();
            header('Location: index.php?url=register');
            exit;
        }

        // Messages
        $success = $_SESSION['success'] ?? null;
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['success'], $_SESSION['errors']);

        require '../views/profil1.php';
    }

    /**
     * Déconnexion
     */
    public function logout(): void
    {
        session_destroy();
        header('Location: index.php?url=home');
        exit;
    }

    /**
     * Affiche le formulaire de modification
     */
    public function showEditForm(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?url=register');
            exit;
        }

        $user = $this->userModel->findById($_SESSION['user_id']);

        if (!$user) {
            session_destroy();
            header('Location: index.php?url=register');
            exit;
        }

        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        $errors = $_SESSION['errors'] ?? [];
        $old = $_SESSION['old'] ?? [];
        unset($_SESSION['errors'], $_SESSION['old']);

        require '../views/ProfilModific1.php';
    }

    /**
     * Traite la modification du profil
     */
    public function update(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?url=register');
            exit;
        }

        $errors = [];
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $csrf = $_POST['csrf_token'] ?? '';

        // Validation CSRF
        if (empty($csrf) || !hash_equals($_SESSION['csrf_token'] ?? '', $csrf)) {
            $errors[] = "Requête invalide.";
        }

        // Validation username et email
        if (strlen($username) < 3) {
            $errors[] = "Nom d'utilisateur trop court (min 3 caractères).";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email invalide.";
        }
        
        // Vérifier si l'email n'est pas déjà utilisé par un autre utilisateur
        $existingUser = $this->userModel->findById($_SESSION['user_id']);
        if ($email !== $existingUser['email'] && $this->userModel->existsByEmail($email)) {
            $errors[] = "Cet email est déjà utilisé par un autre compte.";
        }

        // Validation du changement de mot de passe (si demandé)
        $passwordChange = false;
        if (!empty($currentPassword) || !empty($newPassword) || !empty($confirmPassword)) {
            $passwordChange = true;

            if (empty($currentPassword)) {
                $errors[] = "Veuillez saisir votre mot de passe actuel.";
            }

            if (strlen($newPassword) < 8) {
                $errors[] = "Le nouveau mot de passe doit contenir au moins 8 caractères.";
            }

            if ($newPassword !== $confirmPassword) {
                $errors[] = "Les nouveaux mots de passe ne correspondent pas.";
            }

            // Vérifier que le mot de passe actuel est correct
            if (empty($errors)) {
                $userWithPassword = $this->userModel->findByIdWithPassword($_SESSION['user_id']);
                if (!$userWithPassword || !password_verify($currentPassword, $userWithPassword['password'])) {
                    $errors[] = "Le mot de passe actuel est incorrect.";
                }
            }
        }

        // S'il y a des erreurs, rediriger avec les erreurs
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = ['username' => $username, 'email' => $email];
            header('Location: index.php?url=modifProfil');
            exit;
        }

        // Mise à jour des informations de base
        $success = $this->userModel->update($_SESSION['user_id'], $username, $email);

        if (!$success) {
            $_SESSION['errors'] = ["Erreur lors de la mise à jour du profil."];
            header('Location: index.php?url=modifProfil');
            exit;
        }

        // Mise à jour du mot de passe (si demandé)
        if ($passwordChange) {
            $passwordSuccess = $this->userModel->updatePassword($_SESSION['user_id'], $newPassword);
            if (!$passwordSuccess) {
                $_SESSION['errors'] = ["Profil mis à jour, mais erreur lors du changement de mot de passe."];
                header('Location: index.php?url=modifProfil');
                exit;
            }
        }

        // Mettre à jour les infos en session
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        
        $successMessage = $passwordChange 
            ? "Profil et mot de passe mis à jour avec succès !" 
            : "Profil mis à jour avec succès !";
        
        $_SESSION['success'] = $successMessage;

        header('Location: index.php?url=profil');
        exit;
    }
}