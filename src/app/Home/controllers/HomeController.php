<?php

namespace G1c\Culturia\app\Home\controllers;

use G1c\Culturia\app\Shop\table\ArtworkTable;
use G1c\Culturia\framework\Renderer;

class HomeController
{
    private Renderer $renderer;
    private ArtworkTable $artworkTable;

    public function __construct(Renderer $renderer, ArtworkTable $artworkTable)
    {

        $this->renderer = $renderer;
        $this->artworkTable = $artworkTable;
    }

    public function __invoke()
    {
        return $this->index();
    }
 public function index()
 {
     $artworks = $this->artworkTable->findPublic()->limit(16)->fetchAll();
     return $this->renderer->render("@home/home", compact("artworks"));
 }
}