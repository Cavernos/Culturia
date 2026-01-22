<?php

namespace G1c\Culturia\app\Auth\controllers;

use G1c\Culturia\app\Auth\table\ClientTable;
use G1c\Culturia\app\Shop\table\ArtworkTable;
use G1c\Culturia\app\Shop\table\OrderTable;
use G1c\Culturia\framework\Controllers\SessionCrudController;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Response\RedirectResponse;
use G1c\Culturia\framework\Router\Router;
use G1c\Culturia\framework\Session\FlashService;
use G1c\Culturia\framework\Session\SessionInterface;
use G1c\Culturia\framework\Validator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ProfileController
{
    private Renderer $renderer;


    private ClientTable $clientTable;
    private SessionInterface $session;
    private Router $router;
    private OrderTable $orderTable;
    private ArtworkTable $artworkTable;

    public function __construct(Renderer $renderer,
                                ClientTable $clientTable,
                                OrderTable $orderTable,
                                ArtworkTable $artworkTable,
                                Router $router,
                                SessionInterface $session)
    {
        $this->renderer = $renderer;
        $this->clientTable = $clientTable;
        $this->session = $session;
        $this->router = $router;
        $this->orderTable = $orderTable;
        $this->artworkTable = $artworkTable;
    }

    public function __invoke(ServerRequestInterface $request): string|RedirectResponse
    {
        $this->renderer->addGlobal("viewPath", "@auth/profile");
        if($request->getMethod() === "DELETE") {
            return $this->delete($request);
        }
        if(str_ends_with($request->getUri()->getPath(), "edit")) {
            return $this->edit($request);
        }
        return $this->index($request);
    }

    public function index(ServerRequestInterface $request): string
    {
        $user = $this->clientTable->findById($request->getAttribute("id"));
        $favorites = $this->session->get("favorite", []);
        $orders = $this->orderTable->makeQuery()
            ->select("orders.*")
            ->where("client_id = :id")
            ->params([":id" => $user->id])
            ->fetchAll();
        $order_ids = [];
        foreach ($orders as $order) {
            $order_ids[] = $order->id;
        }
        $artworks = $this->artworkTable->makeQuery()
            ->where("order_id IN (:id)")
            ->params([":id" => implode(", ", $order_ids)])
        ->fetchAll();
        if(isset($favorites[$user->id])) {
            $favorites = $favorites[$user->id];
        }
        return $this->renderer->render("@auth/profile/index", compact("user", "favorites"));
    }

    public function edit(ServerRequestInterface $request): string|RedirectResponse
    {
        $errors = null;
        $user = $this->clientTable->findById($request->getAttribute("id"));
        if($request->getMethod() === "POST") {
            $params = array_filter($request->getParsedBody(), function ($value) {
                return in_array($value, ["email", "username"]);
            }, ARRAY_FILTER_USE_KEY);
            if($params['email'] !== $user->email || $params['username'] !== $user->username) {
                $validator = (new Validator($params))
                    ->required("username", "email")
                    ->length("username", 3, 255)
                    ->length("email", 3, 255)
                    ->exists("username",
                        $this->clientTable->getTable(),
                        $this->clientTable->getPdo(),
                        $user->id,
                    )
                    ->exists("email",
                        $this->clientTable->getTable(),
                        $this->clientTable->getPdo(),
                        $user->id
                    );
                $errors = $validator->getErrors();
                if(count($errors) === 0) {
                    $this->clientTable->update($user->id, $params);
                    (new FlashService($this->session))->success("Profil modifié avec succès");
                    $path = $this->router->generateUri("auth.index", ["id" => $user->id]);
                    return new RedirectResponse($path);
                }
                (new FlashService($this->session))->error("Il manque des informations pour le profil");
            }
        }
        return $this->renderer->render("@auth/profile/edit", compact("user", "errors"));

    }

    public function delete(ServerRequestInterface $request): string|ResponseInterface
    {
        $id = $request->getAttribute("id");
        $this->clientTable->delete($id);
        (new FlashService($this->session))->success("Profil supprimé avec succès");
        return new RedirectResponse("/");
    }
}