<?php
// app/Models/User.php
class User
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = new PDO(
            'mysql:host=localhost;dbname=culturia_v2;charset=utf8',
            'root',
            ''
        );
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Crée un nouvel utilisateur
     * @return int|false L'ID du nouvel utilisateur ou false en cas d'erreur
     */
    public function create(string $email, string $password, string $username): int|false
    {
        $sql = "INSERT INTO clients (username, email, password, created_at)
                VALUES (:username, :email, :password, NOW())";
        $stmt = $this->db->prepare($sql);

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $success = $stmt->execute([
            ':email'    => $email,
            ':password' => $hash,
            ':username' => $username
        ]);

        return $success ? (int)$this->db->lastInsertId() : false;
    }

    /**
     * Vérifie si un email existe déjà
     */
    public function existsByEmail(string $email): bool
    {
        $stmt = $this->db->prepare("SELECT id FROM clients WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return (bool) $stmt->fetch();
    }

    /**
     * Récupère un utilisateur par son ID (sans le mot de passe)
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT id, username, email, created_at FROM clients WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    /**
     * Récupère un utilisateur par son ID (avec le mot de passe pour vérification) pour verifier le mot de passe actuel lors d'un changement
     */
    public function findByIdWithPassword(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT id, username, email, password, created_at FROM clients WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    /**
     * Met à jour les informations d'un utilisateur
     */
    public function update(int $id, string $username, string $email): bool
    {
        $sql = "UPDATE clients SET username = :username, email = :email WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':id' => $id,
            ':username' => $username,
            ':email' => $email
        ]);
    }

    /**
     * Change le mot de passe d'un utilisateur
     */
    public function updatePassword(int $id, string $newPassword): bool
    {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE clients SET password = :password WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':id' => $id,
            ':password' => $hash
        ]);
    }
}