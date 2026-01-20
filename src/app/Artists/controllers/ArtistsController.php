<?php

namespace G1c\Culturia\app\Artists\controllers;

use G1c\Culturia\app\Artists\table\ArtistsTable;
use G1c\Culturia\framework\Renderer;
use Psr\Http\Message\ServerRequestInterface;

class ArtistsController
{
    private ArtistsTable $artistsTable;
    private Renderer $renderer;

    public function __construct(ArtistsTable $artistsTable, Renderer $renderer)
    {

        $this->artistsTable = $artistsTable;
        $this->renderer = $renderer;
    }
    public function __invoke(ServerRequestInterface $request): string
    {
        $artists = $this->artistsTable->makeQuery()->paginate(16, $_GET["p"] ?? 1);
        return $this->renderer->render("@artists/index", compact("artists"));
    }

}