<?php
require_once __DIR__ . '/../../config/database.php';

class ProfileModel {
    private $db;

    public function __construct() {
        try {
            $database = new Database();
            $this->db = $database->getConnection();
        } catch (Exception $e) {
            error_log("Erreur ProfileModel __construct: " . $e->getMessage());
            throw $e;
        }
    }

    public function getProfileById($userId) {
        try {
            $query = "SELECT * FROM users WHERE id = :user_id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur getProfileById: " . $e->getMessage());
            return null;
        }
    }

    public function updateProfile($userId, $data) {
        try {
            $query = "UPDATE users SET 
                      prenom = :prenom,
                      nom = :nom,
                      nom_utilisateur = :nom_utilisateur,
                      email = :email,
                      telephone = :telephone,
                      biographie = :biographie,
                      ville = :ville,
                      pays = :pays,
                      type_artiste = :type_artiste,
                      specialites = :specialites,
                      annees_experience = :annees_experience,
                      site_web = :site_web,
                      instagram = :instagram,
                      facebook = :facebook,
                      twitter_x = :twitter_x,
                      updated_at = CURRENT_TIMESTAMP
                      WHERE id = :user_id";
            
            $stmt = $this->db->prepare($query);
            
            // Bind des paramètres
            $stmt->bindParam(':prenom', $data['prenom']);
            $stmt->bindParam(':nom', $data['nom']);
            $stmt->bindParam(':nom_utilisateur', $data['nom_utilisateur']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':telephone', $data['telephone']);
            $stmt->bindParam(':biographie', $data['biographie']);
            $stmt->bindParam(':ville', $data['ville']);
            $stmt->bindParam(':pays', $data['pays']);
            $stmt->bindParam(':type_artiste', $data['type_artiste']);
            $stmt->bindParam(':specialites', $data['specialites']);
            $stmt->bindParam(':annees_experience', $data['annees_experience']);
            $stmt->bindParam(':site_web', $data['site_web']);
            $stmt->bindParam(':instagram', $data['instagram']);
            $stmt->bindParam(':facebook', $data['facebook']);
            $stmt->bindParam(':twitter_x', $data['twitter_x']);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            
            $result = $stmt->execute();
            
            // Si une photo a été uploadée, mettre à jour le chemin
            if (isset($data['photo_path']) && $result) {
                $this->updateProfilePhoto($userId, $data['photo_path']);
            }
            
            return $result;
        } catch (PDOException $e) {
            error_log("Erreur updateProfile: " . $e->getMessage());
            return false;
        }
    }

    public function updateProfilePhoto($userId, $photoPath) {
        try {
            // Si une colonne photo_path existe dans la table users
            $query = "UPDATE users SET photo_path = :photo_path WHERE id = :user_id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':photo_path', $photoPath);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            // Si la colonne n'existe pas, on l'ignore
            error_log("Info: photo_path column may not exist: " . $e->getMessage());
            return true;
        }
    }

    public function updatePassword($userId, $newPassword) {
        try {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            
            $query = "UPDATE users SET mot_de_passe = :password, updated_at = CURRENT_TIMESTAMP WHERE id = :user_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur updatePassword: " . $e->getMessage());
            return false;
        }
    }

    public function verifyPassword($userId, $password) {
        try {
            $query = "SELECT mot_de_passe FROM users WHERE id = :user_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                return password_verify($password, $result['mot_de_passe']);
            }
            
            return false;
        } catch (PDOException $e) {
            error_log("Erreur verifyPassword: " . $e->getMessage());
            return false;
        }
    }

    public function usernameExists($username, $excludeUserId = null) {
        try {
            $query = "SELECT id FROM users WHERE nom_utilisateur = :username";
            if ($excludeUserId) {
                $query .= " AND id != :exclude_id";
            }
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username);
            if ($excludeUserId) {
                $stmt->bindParam(':exclude_id', $excludeUserId, PDO::PARAM_INT);
            }
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
        } catch (PDOException $e) {
            error_log("Erreur usernameExists: " . $e->getMessage());
            return false;
        }
    }

    public function emailExists($email, $excludeUserId = null) {
        try {
            $query = "SELECT id FROM users WHERE email = :email";
            if ($excludeUserId) {
                $query .= " AND id != :exclude_id";
            }
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email);
            if ($excludeUserId) {
                $stmt->bindParam(':exclude_id', $excludeUserId, PDO::PARAM_INT);
            }
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
        } catch (PDOException $e) {
            error_log("Erreur emailExists: " . $e->getMessage());
            return false;
        }
    }

    public function deleteAccount($userId) {
        try {
            // Récupérer le chemin de la photo pour la supprimer
            $profile = $this->getProfileById($userId);
            
            // Supprimer l'utilisateur
            $query = "DELETE FROM users WHERE id = :user_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $result = $stmt->execute();
            
            // Supprimer la photo du serveur si elle existe
            if ($result && isset($profile['photo_path']) && !empty($profile['photo_path'])) {
                $photoPath = __DIR__ . '/../../public/' . $profile['photo_path'];
                if (file_exists($photoPath)) {
                    unlink($photoPath);
                }
            }
            
            return $result;
        } catch (PDOException $e) {
            error_log("Erreur deleteAccount: " . $e->getMessage());
            return false;
        }
    }

    public function getUserStats($userId) {
        try {
            // Cette fonction pourrait récupérer des statistiques sur l'utilisateur
            // (nombre d'œuvres, de ventes, etc.)
            $query = "SELECT 
                        COUNT(*) as total_artworks,
                        (SELECT COUNT(*) FROM orders WHERE artist_id = :user_id) as total_sales
                      FROM artworks WHERE artist_id = :user_id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Si les tables n'existent pas encore, retourner des valeurs par défaut
            return [
                'total_artworks' => 0,
                'total_sales' => 0
            ];
        }
    }
}