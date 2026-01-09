<?php
// require_once __DIR__ . '/../config/database.php';

// class ContactModel {
//     private $db;

//     public function __construct() {
//         $database = new Database();
//         $this->db = $database->getConnection();
//     }

//     public function saveMessage($name, $email, $phone, $subject, $message) {
//         try {
//             $query = "INSERT INTO contact_messages (name, email, phone, subject, message, created_at) 
//                       VALUES (:name, :email, :phone, :subject, :message, NOW())";
            
//             $stmt = $this->db->prepare($query);
            
//             $stmt->bindParam(':name', $name);
//             $stmt->bindParam(':email', $email);
//             $stmt->bindParam(':phone', $phone);
//             $stmt->bindParam(':subject', $subject);
//             $stmt->bindParam(':message', $message);
            
//             return $stmt->execute();
//         } catch (PDOException $e) {
//             error_log("Erreur lors de la sauvegarde du message: " . $e->getMessage());
//             return false;
//         }
//     }

//     public function getAllMessages() {
//         try {
//             $query = "SELECT * FROM contact_messages ORDER BY created_at DESC";
//             $stmt = $this->db->prepare($query);
//             $stmt->execute();
//             return $stmt->fetchAll(PDO::FETCH_ASSOC);
//         } catch (PDOException $e) {
//             error_log("Erreur lors de la récupération des messages: " . $e->getMessage());
//             return [];
//         }
//     }

//     public function getMessageById($id) {
//         try {
//             $query = "SELECT * FROM contact_messages WHERE id = :id";
//             $stmt = $this->db->prepare($query);
//             $stmt->bindParam(':id', $id);
//             $stmt->execute();
//             return $stmt->fetch(PDO::FETCH_ASSOC);
//         } catch (PDOException $e) {
//             error_log("Erreur lors de la récupération du message: " . $e->getMessage());
//             return null;
//         }
//     }
// }



// CREATE TABLE IF NOT EXISTS contact_messages (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     name VARCHAR(255) NOT NULL,
//     email VARCHAR(255) NOT NOT,
//     phone VARCHAR(50),
//     subject VARCHAR(255) NOT NULL,
//     message TEXT NOT NULL,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     is_read BOOLEAN DEFAULT FALSE,
//     INDEX idx_created_at (created_at),
//     INDEX idx_is_read (is_read)
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;