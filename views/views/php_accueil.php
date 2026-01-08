<?php
$pdo = new PDO('mysql:host=localhost;dbname=culturia_test;charset=utf8mb4', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Exemples de données pour l'accueil
// 1) catégories
$stmt = $pdo->query("SELECT id, name, description FROM category ORDER BY name");
$categories = $stmt->fetchAll();

// 2) œuvres mises en avant
$stmt = $pdo->query("
    SELECT a.id, a.name, a.image, a.price
    FROM artwork a
    ORDER BY a.creation_date DESC
    LIMIT 6
");
$artworks = $stmt->fetchAll();
?>
