<?php

namespace G1c\Culturia\app\Home\controllers;

use G1c\Culturia\app\Shop\table\ArtworkTable;
use G1c\Culturia\app\Shop\table\CategoryTable;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Session\SessionInterface;

class HomeController
{
    private Renderer $renderer;
    private ArtworkTable $artworkTable;
    private SessionInterface $session;
    private CategoryTable $categoryTable;

    public function __construct(Renderer $renderer, ArtworkTable $artworkTable,
                                CategoryTable $categoryTable, SessionInterface $session)
    {

        $this->renderer = $renderer;
        $this->artworkTable = $artworkTable;
        $this->session = $session;
        $this->categoryTable = $categoryTable;
    }

    public function __invoke()
    {
        return $this->index();
    }
 public function index()
 {
     $artworks = $this->artworkTable->findRecent()->fetchAll();
     $categories = $this->categoryTable->makeQuery()->limit(10)->fetchAll();
     return $this->renderer->render("@home/home", compact("artworks", "categories"));
 }

 public function faq()
 {
     return $this->renderer->render("@home/faq");
 }
}