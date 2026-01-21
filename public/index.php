<?php
session_start();

require_once __DIR__ . '/../app/controllers/MainController.php';
require_once __DIR__ . '/../app/Models/User.php';
require_once __DIR__ . '/../app/controllers/RegisterController.php';
require_once __DIR__ . '/../app/controllers/ProfilController.php';

$route = $_GET['url'] ?? 'home';

switch($route) {
    case 'home':
        $controller = new MainController();
        $controller->index();
        break;

    case 'faq':
        require '../views/faq.php';
        break;
    
    case 'cgu':
        require '../views/cgu.php';
        break;
    
    case 'profil':
        $controller = new ProfilController();
        $controller->index();
        break;

    case 'modifProfil':
        $controller = new ProfilController();
        $controller->showEditForm();
        break;

    case 'updateProfil':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller = new ProfilController();
            $controller->update();
        } else {
            header('Location: index.php?url=profil');
            exit;
        }
        break;

    case 'logout':
        $controller = new ProfilController();
        $controller->logout();
        break;
    
    case 'register':
        $controller = new RegisterController();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->register();
        } else {
            $controller->showForm();
        }
        break;

    default:
        echo "Page non trouvée !";
        break;
}