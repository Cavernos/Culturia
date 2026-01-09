<?php
require_once __DIR__ . '/../models/ContactModele.php';

class ContactController {
    private $contactModel;

    public function __construct() {
        // $this->contactModel = new ContactModel();
    }

    public function index() {
        require '../views/contact.php';
    }

    public function sendMessage() {
        header('Content-Type: application/json');
        
        // Vérifier que c'est une requête POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
            return;
        }

        // Récupérer et nettoyer les données
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        // Validation
        $errors = [];

        if (empty($name)) {
            $errors['name'] = 'Le nom est requis';
        }

        if (empty($email)) {
            $errors['email'] = 'L\'email est requis';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'L\'email n\'est pas valide';
        }

        if (empty($subject)) {
            $errors['subject'] = 'Le sujet est requis';
        }

        if (empty($message)) {
            $errors['message'] = 'Le message est requis';
        } elseif (strlen($message) < 10) {
            $errors['message'] = 'Le message doit contenir au moins 10 caractères';
        }

        // Si erreurs, retourner les erreurs
        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'errors' => $errors]);
            return;
        }

        // Sauvegarder le message
        // $result = $this->contactModel->saveMessage($name, $email, $phone, $subject, $message);
        $result = true; // Simuler une sauvegarde réussie

        if ($result) {
            // Envoyer l'email (optionnel)
            $this->sendEmailNotification($name, $email, $subject, $message);

            echo json_encode([
                'success' => true,
                'message' => 'Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'envoi du message. Veuillez réessayer.'
            ]);
        }
    }

    private function sendEmailNotification($name, $email, $subject, $message) {
        $to = 'contact@culturia.fr'; // Votre email
        $emailSubject = 'Nouveau message de contact - ' . $subject;
        
        $emailBody = "Nouveau message de contact:\n\n";
        $emailBody .= "Nom: $name\n";
        $emailBody .= "Email: $email\n";
        $emailBody .= "Sujet: $subject\n\n";
        $emailBody .= "Message:\n$message\n";

        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Envoyer l'email
        mail($to, $emailSubject, $emailBody, $headers);
    }
}