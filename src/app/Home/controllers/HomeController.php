<?php

namespace G1c\Culturia\app\Home\controllers;

use G1c\Culturia\app\Shop\table\ArtworkTable;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Session\SessionInterface;

class HomeController
{
    private Renderer $renderer;
    private ArtworkTable $artworkTable;
    private SessionInterface $session;

    public function __construct(Renderer $renderer, ArtworkTable $artworkTable, SessionInterface $session)
    {

        $this->renderer = $renderer;
        $this->artworkTable = $artworkTable;
        $this->session = $session;
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

 public function faq()
 {
     return $this->renderer->render("@home/faq");
 }
}