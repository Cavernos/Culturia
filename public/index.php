<?php

// use G1c\Culturia\app\App;
// use G1c\Culturia\app\Artists\ArtistsModule;
// use G1c\Culturia\app\Auth\AuthModule;
// use G1c\Culturia\app\Home\HomeModule;
// use G1c\Culturia\app\Shop\ShopModule;
// use G1c\Culturia\framework\Middlewares\MethodMiddleware;
// use G1c\Culturia\framework\Middlewares\NotFoundMiddleware;
// use G1c\Culturia\framework\Middlewares\RouterMiddleware;
// use G1c\Culturia\framework\Middlewares\TrailingSlashMiddleware;

// chdir(dirname(__DIR__));
// require_once "vendor/autoload.php";



// $app = new App(dirname(__DIR__). '/config/config.php');



// $app->add(ShopModule::class)
//     ->add(AuthModule::class)
//     ->add(HomeModule::class)
//     ->add(ArtistsModule::class);

// $app->pipe(TrailingSlashMiddleware::class)
//     ->pipe(MethodMiddleware::class)
//     ->pipe(RouterMiddleware::class)
//     ->pipe(NotFoundMiddleware::class);
// if (php_sapi_name() !== 'cli') {
//     $response = $app->run($_SERVER);
// }


require_once __DIR__ . '/../app/controllers/MainController.php';
require_once __DIR__ . '/../app/controllers/ContactController.php';
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
        try {
            $controller = new ProfilController();
            $controller->index();
        } catch (Exception $e) {
            error_log("Erreur modifProfil: " . $e->getMessage());
            echo "Une erreur est survenue";
        }
        break;

    case 'modifProfil':
        try {
            $controller = new ProfilController();
            $controller->indexModifProfil();
        } catch (Exception $e) {
            error_log("Erreur modifProfil: " . $e->getMessage());
            echo "Une erreur est survenue";
        }
        break;
    
    case 'saveSettings':
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            // Ici on pourrait sauvegarder en base de données
            // Pour l'instant, on simule juste l'enregistrement
            echo json_encode(['success' => true, 'message' => 'Paramètres enregistrés']);
        }
        break;
    
    case 'contact':
        $controller = new ContactController();
        $controller->index();
        break;
    
    case 'contact/send':
        $controller = new ContactController();
        $controller->sendMessage();
        break;
    case 'profil/update':
        try {
            $controller = new ProfilController();
            $controller->update();
        } catch (Exception $e) {
            error_log("Erreur profil/update: " . $e->getMessage());
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Erreur serveur']);
        }
        break;

    default:
        echo "Page non trouvée !";
        break;
}
