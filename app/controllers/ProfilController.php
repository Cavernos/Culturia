<?php
require_once __DIR__ . '/../models/ProfileModel.php';

class ProfilController {
    private $profileModel;

    public function __construct() {
        // Vérifier que l'utilisateur est connecté
        session_start();
        $_SESSION['user_id'] = 1; // À supprimer : juste pour les tests
        // if (!isset($_SESSION['user_id'])) {
        //     header('Location: index.php?url=connexion');
        //     exit();
        // }
        
        $this->profileModel = new ProfileModel();
    }

    public function index() {
        // Récupérer les données du profil
        $userId = $_SESSION['user_id'];
        $profile = $this->profileModel->getProfileById($userId);
        
        // Passer les données à la vue
        require '../views/Profil.php';
    }

    public function indexModifProfil() {
        // Récupérer les données du profil
        // $userId = $_SESSION['user_id'];
        // $profile = $this->profileModel->getProfileById($userId);
        
        // Passer les données à la vue
        $userId = $_SESSION['user_id'];
        $profile = $this->profileModel->getProfileById($userId);
        require '../views/ProfilModific.php';
    }

    public function update() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
            return;
        }

        $userId = $_SESSION['user_id'];

        // Récupérer et nettoyer les données
        $data = [
            'prenom' => trim($_POST['firstName'] ?? ''),
            'nom' => trim($_POST['lastName'] ?? ''),
            'nom_utilisateur' => trim($_POST['username'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'telephone' => trim($_POST['phone'] ?? ''),
            'biographie' => trim($_POST['bio'] ?? ''),
            'ville' => trim($_POST['city'] ?? ''),
            'pays' => trim($_POST['country'] ?? ''),
            'type_artiste' => trim($_POST['artistType'] ?? ''),
            'specialites' => trim($_POST['specialties'] ?? ''),
            'annees_experience' => trim($_POST['experience'] ?? ''),
            'site_web' => trim($_POST['website'] ?? ''),
            'instagram' => trim($_POST['instagram'] ?? ''),
            'facebook' => trim($_POST['facebook'] ?? ''),
            'twitter_x' => trim($_POST['twitter'] ?? '')
        ];

        // Validation
        $errors = $this->validateProfileData($data);
        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'errors' => $errors, 'message' => implode(', ', $errors)]);
            return;
        }

        // Vérifier si le nom d'utilisateur existe déjà pour un autre utilisateur
        if ($this->profileModel->usernameExists($data['nom_utilisateur'], $userId)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Ce nom d\'utilisateur est déjà utilisé']);
            return;
        }

        // Gérer le changement de mot de passe
        if (!empty($_POST['currentPassword']) && !empty($_POST['newPassword'])) {
            $currentPassword = $_POST['currentPassword'];
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'] ?? '';

            // Vérifier que les mots de passe correspondent
            if ($newPassword !== $confirmPassword) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Les mots de passe ne correspondent pas']);
                return;
            }

            // Vérifier le mot de passe actuel
            if (!$this->profileModel->verifyPassword($userId, $currentPassword)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Mot de passe actuel incorrect']);
                return;
            }

            // Valider la force du nouveau mot de passe
            if (strlen($newPassword) < 8) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Le mot de passe doit contenir au moins 8 caractères']);
                return;
            }

            // Mettre à jour le mot de passe
            if (!$this->profileModel->updatePassword($userId, $newPassword)) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour du mot de passe']);
                return;
            }
        }

        // Gérer l'upload de la photo de profil
        if (isset($_FILES['profilePhoto']) && $_FILES['profilePhoto']['error'] === UPLOAD_ERR_OK) {
            $photoPath = $this->handlePhotoUpload($_FILES['profilePhoto'], $userId);
            if ($photoPath === false) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'upload de la photo']);
                return;
            }
            $data['photo_path'] = $photoPath;
        }

        // Mettre à jour le profil
        $result = $this->profileModel->updateProfile($userId, $data);

        if ($result) {
            // Mettre à jour la session si nécessaire
            $_SESSION['nom_utilisateur'] = $data['nom_utilisateur'];
            $_SESSION['prenom'] = $data['prenom'];
            $_SESSION['nom'] = $data['nom'];

            echo json_encode([
                'success' => true,
                'message' => 'Profil mis à jour avec succès'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du profil'
            ]);
        }
    }

    public function delete() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
            return;
        }

        $userId = $_SESSION['user_id'];
        $input = json_decode(file_get_contents('php://input'), true);
        $password = $input['password'] ?? '';

        if (empty($password)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Mot de passe requis']);
            return;
        }

        // Vérifier le mot de passe
        if (!$this->profileModel->verifyPassword($userId, $password)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Mot de passe incorrect']);
            return;
        }

        // Supprimer le compte
        $result = $this->profileModel->deleteAccount($userId);

        if ($result) {
            // Détruire la session
            session_destroy();
            
            echo json_encode([
                'success' => true,
                'message' => 'Compte supprimé avec succès'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Erreur lors de la suppression du compte'
            ]);
        }
    }

    private function validateProfileData($data) {
        $errors = [];

        if (empty($data['prenom'])) {
            $errors['prenom'] = 'Le prénom est requis';
        }

        if (empty($data['nom'])) {
            $errors['nom'] = 'Le nom est requis';
        }

        if (empty($data['nom_utilisateur'])) {
            $errors['nom_utilisateur'] = 'Le nom d\'utilisateur est requis';
        } elseif (strlen($data['nom_utilisateur']) < 3) {
            $errors['nom_utilisateur'] = 'Le nom d\'utilisateur doit contenir au moins 3 caractères';
        }

        if (empty($data['email'])) {
            $errors['email'] = 'L\'email est requis';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'L\'email n\'est pas valide';
        }

        // Validation du téléphone (optionnel mais doit être valide s'il est fourni)
        if (!empty($data['telephone'])) {
            // Format français : +33 6 12 34 56 78 ou 06 12 34 56 78
            $phone = str_replace(' ', '', $data['telephone']);
            if (!preg_match('/^(\+33|0)[1-9]\d{8}$/', $phone)) {
                $errors['telephone'] = 'Le format du téléphone n\'est pas valide';
            }
        }

        // Validation des URLs
        if (!empty($data['site_web']) && !filter_var($data['site_web'], FILTER_VALIDATE_URL)) {
            $errors['site_web'] = 'L\'URL du site web n\'est pas valide';
        }

        if (!empty($data['facebook']) && !filter_var($data['facebook'], FILTER_VALIDATE_URL)) {
            $errors['facebook'] = 'L\'URL Facebook n\'est pas valide';
        }

        return $errors;
    }

    private function handlePhotoUpload($file, $userId) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        // Vérifier le type
        if (!in_array($file['type'], $allowedTypes)) {
            error_log("Type de fichier non autorisé: " . $file['type']);
            return false;
        }

        // Vérifier la taille
        if ($file['size'] > $maxSize) {
            error_log("Fichier trop volumineux: " . $file['size']);
            return false;
        }

        // Créer le dossier si nécessaire
        $uploadDir = __DIR__ . '/../../public/uploads/profiles/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Générer un nom unique
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'profile_' . $userId . '_' . time() . '.' . $extension;
        $filepath = $uploadDir . $filename;

        // Déplacer le fichier
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return 'uploads/profiles/' . $filename;
        }

        error_log("Erreur lors du déplacement du fichier");
        return false;
    }
}