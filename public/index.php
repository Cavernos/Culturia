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
session_start();

require_once __DIR__ . '/../app/controllers/MainController.php';

require_once __DIR__ . '/../app/Models/User.php';
require_once __DIR__ . '/../app/Controllers/RegisterController.php';

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
        require '../views/profil.php';
        break;

    case 'modifProfil':
        require '../views/ProfilModific.php';
        break;
    
    case 'register':
        $controller = new RegisterController();
    
    // Vérifier si c'est une soumission POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->register();  // Traiter l'inscription
        } else {
            $controller->showForm();  // Afficher le formulaire
        }
        break;

    default:
        echo "Page non trouvée !";
        break;
}
