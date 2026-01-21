<?php
// app/Controllers/RegisterController.php
class RegisterController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function showForm(): void
    {
        // Si déjà connecté, redirige vers le profil
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php?url=profil');
            exit;
        }

        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        $errors  = $_SESSION['errors']  ?? [];
        $old     = $_SESSION['old']     ?? [];
        $success = $_SESSION['success'] ?? null;

        unset($_SESSION['errors'], $_SESSION['old'], $_SESSION['success']);

        require '../views/register.php';
    }
    /* train=tement de l'inscription*/
    public function register(): void
    {
        $errors = [];

        $email    = trim($_POST['email'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['confirm_password'] ?? '';
        $csrf     = $_POST['csrf_token'] ?? '';

        if (empty($csrf) || !hash_equals($_SESSION['csrf_token'] ?? '', $csrf)) {
            $errors[] = "Requête invalide, veuillez réessayer.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email invalide.";
        }

        if (strlen($username) < 3) {
            $errors[] = "Nom d'utilisateur trop court (min 3 caractères).";
        }

        if (strlen($password) < 8) {
            $errors[] = "Mot de passe trop court (min 8 caractères).";
        }

        if ($password !== $confirm) {
            $errors[] = "Les mots de passe ne correspondent pas.";
        }

        if ($this->userModel->existsByEmail($email)) {
            $errors[] = "Un compte existe déjà avec cet email.";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = [
                'email'    => $email,
                'username' => $username
            ];
            header('Location: index.php?url=register');
            exit;
        }

        // Créer l'utilisateur et récupérer son ID
        $userId = $this->userModel->create($email, $password, $username);

        if ($userId) {
            // Connecter automatiquement l'utilisateur
            $_SESSION['user_id'] = $userId;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['success'] = "Compte créé avec succès ! Bienvenue $username ";
            
            // Rediriger vers le profil
            header('Location: index.php?url=profil');
            exit;
        } else {
            $_SESSION['errors'] = ["Une erreur s'est produite lors de la création du compte."];
            header('Location: index.php?url=register');
            exit;
        }
    }
}