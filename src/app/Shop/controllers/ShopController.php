<?php namespace G1c\Culturia\app\Shop\controllers;

use G1c\Culturia\app\Shop\table\ArtworkTable;
use G1c\Culturia\framework\Logger;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Router\Router;
use G1c\Culturia\framework\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface;

class ShopController {
    private $renderer;
    private $table;
    private Router $router;
    private Logger $logger;

    public function __construct(Logger $logger, Renderer $renderer,
                                Router $router,
                                ArtworkTable $table,
    ) {
        $this->renderer = $renderer;
        $this->table = $table;
        $this->router = $router;
        $this->logger = $logger;
    }
    
    public function __invoke(ServerRequestInterface $request): string
    {
        if($request->getAttribute("id")) {
            return $this->view($request);
        }
        return $this->index($request);
    }
    public function index(ServerRequestInterface $request){
        $filter_param = array_intersect_key($_GET, array_flip(["price", "artists"]));
        if(!empty($filter_param)) {
            $artworks = $this->table
                ->findPublic()
                ->filter($filter_param, ["artists" => "artists.id"])
                ->paginate(16, $_GET["p"] ?? 1);
        } else {
            $artworks = $this->table->findPublic()->paginate(16, $_GET["p"] ?? 1);
        }
        return $this->render('@shop/shop', compact("artworks"));
    }
    public function view(ServerRequestInterface $request): string {
        $artwork = $this->table->findPublicId($request->getAttribute("id"))->fetchOrFail();
        $similar_artworks = $this->table->findPublic()->limit(4)->fetchAll();
        return $this->render('@shop/show', compact("artwork", "similar_artworks"));
        
    }

    private function render(string $view, $args = []): string
    {
        $this->logger->info("Rendering $view");
        return $this->renderer->render($view, $args);
    }
}