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

    public function create(string $email, string $password, string $username): bool
    {
        $sql = "INSERT INTO clients (username, email, password)
                VALUES (:username, :email, :password)";
        $stmt = $this->db->prepare($sql);

        $hash = password_hash($password, PASSWORD_DEFAULT);

        return $stmt->execute([
            ':email'    => $email,
            ':password' => $hash,
            ':username' => $username
        ]);
    }

    public function existsByEmail(string $email): bool
        {
            $stmt = $this->db->prepare("SELECT id FROM clients WHERE email = :email");
            $stmt->execute([':email' => $email]);
            return (bool) $stmt->fetch();
        }
}
