<?php namespace G1c\Culturia\app\Shop\controllers;

use G1c\Culturia\app\Shop\table\ArtworkTable;
use G1c\Culturia\framework\Renderer;

class ShopController {
    private $renderer;
    private $table;
    public function __construct(Renderer $renderer, ArtworkTable $table) {
        $this->renderer = $renderer;
        $this->table = $table;
    }
    
    public function __invoke()
    {
        
        return $this->index();
    }
    public function index(){
        $artworks = $this->table->makeQuery()->fetchAll();
        return $this->renderer->render('@shop/shop', compact("artworks"));
    }
    public function view($slug, $id) {
        return null;
        
    }
}