<?php

namespace G1c\Culturia\app\Auth\controllers;

use G1c\Culturia\app\Auth\table\ClientTable;
use G1c\Culturia\app\Shop\table\ArtworkTable;
use G1c\Culturia\framework\Controllers\SessionCrudController;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Router\Router;
use G1c\Culturia\framework\Session\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ProfileController
{
    private Renderer $renderer;


    private ClientTable $clientTable;
    private SessionInterface $session;

    public function __construct(Renderer $renderer, ClientTable $clientTable, SessionInterface $session)
    {
        $this->renderer = $renderer;
        $this->clientTable = $clientTable;
        $this->session = $session;
    }

    public function __invoke(ServerRequestInterface $request): string
    {
        return $this->index($request);
    }

    public function index(ServerRequestInterface $request): string
    {
        $user = $this->clientTable->findById($request->getAttribute("id"));
        $favorites = $this->session->get("favorite", []);
        if(isset($favorites[$user->id])) {
            $favorites = $favorites[$user->id];
        }
        return $this->renderer->render("@auth/profile/index", compact("user", "favorites"));
    }
}