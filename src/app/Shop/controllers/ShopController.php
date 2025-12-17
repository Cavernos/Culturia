<?php namespace G1c\Culturia\app\Shop\controllers;

use G1c\Culturia\app\Shop\table\ArtworkTable;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Router\Router;

class ShopController {
    private $renderer;
    private $table;
    private Router $router;

    public function __construct(Renderer $renderer, Router $router, ArtworkTable $table) {
        $this->renderer = $renderer;
        $this->table = $table;
        $this->router = $router;
    }
    
    public function __invoke()
    {
        
        return $this->index();
    }
    public function index(){
        $artworks = $this->table->findPublic()->paginate(16, $_GET["p"] ?? 1);
        $prev = $artworks->previous();
        $next = $artworks->next();
        return $this->renderer->render('@shop/shop', compact("artworks", "prev", "next"));
    }
    public function view($slug, $id) {
        return null;
        
    }
}