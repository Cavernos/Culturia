<?php

namespace G1c\Culturia\app\Home\controllers;

use G1c\Culturia\app\Artists\table\ArtistsTable;
use G1c\Culturia\app\Shop\table\ArtworkTable;
use G1c\Culturia\app\Shop\table\CategoryTable;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeController
{
    private Renderer $renderer;
    private ArtworkTable $artworkTable;
    private SessionInterface $session;
    private CategoryTable $categoryTable;
    private ArtistsTable $artistsTable;

    public function __construct(Renderer $renderer,
                                ArtworkTable $artworkTable,
                                CategoryTable $categoryTable,
                                ArtistsTable $artistsTable,
                                SessionInterface $session)
    {

        $this->renderer = $renderer;
        $this->artworkTable = $artworkTable;
        $this->session = $session;
        $this->categoryTable = $categoryTable;
        $this->artistsTable = $artistsTable;
    }

    public function __invoke(ServerRequestInterface $request): string
    {
        if(str_contains($request->getUri()->getPath(), "faq")){
            return $this->faq($request);
        }
        return $this->index($request);
    }
 public function index(ServerRequestInterface $request): string
 {
     $artworks = $this->artworkTable->findRecent()->fetchAll();
     $categories = $this->categoryTable->makeQuery()->limit(10)->fetchAll();
     $artists = $this->artistsTable->makeQuery()->limit(30)->fetchAll();
     return $this->renderer->render("@home/home", compact("artworks", "categories", "artists"));
 }

 public function faq(ServerRequestInterface $request): string
 {
     return $this->renderer->render("@home/faq");
 }
}