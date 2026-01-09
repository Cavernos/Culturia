<?php

namespace G1c\Culturia\app\Artists;

use G1c\Culturia\app\Artists\controllers\ArtistProfileController;
use G1c\Culturia\app\Artists\controllers\ArtistsController;
use G1c\Culturia\framework\Container;
use G1c\Culturia\framework\Module;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Router\Router;

class ArtistsModule extends Module
{
    public const DEFINITIONS = __DIR__ . "/config.php";
    public const MIGRATIONS = __DIR__ . "/db/migrations";
    public const SEEDS = __DIR__ . "/db/seeds";

    /**
     * @param Container $c
     */
    public function __construct(Container $c)
    {
        /**
         * @var Renderer $renderer
         * @var Router $router
         * */
        $prefix = $c->get("artists.prefix");
        $renderer = $c->get(Renderer::class);
        $renderer->addPath("artists", __DIR__ . "/views");
        $router = $c->get(Router::class);
        $router->get($prefix, ArtistsController::class, "artists.index");
        $router->get($prefix . "/{id:[0-9]+}", ArtistProfileController::class, "artists.profile");

    }
}