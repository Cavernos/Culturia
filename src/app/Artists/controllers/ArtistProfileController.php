<?php

namespace G1c\Culturia\app\Artists\controllers;


use G1c\Culturia\app\Artists\table\ArtistsTable;
use G1c\Culturia\app\Shop\table\ArtworkTable;
use G1c\Culturia\app\Shop\table\OrderTable;
use G1c\Culturia\framework\Database\NoRecordException;
use G1c\Culturia\framework\Database\QueryResult;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Response\RedirectResponse;
use G1c\Culturia\framework\Router\Router;
use G1c\Culturia\framework\Session\FlashService;
use G1c\Culturia\framework\Session\SessionInterface;
use G1c\Culturia\framework\Validator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ArtistProfileController
{
    private Renderer $renderer;
    private ArtistsTable $artistsTable;
    private ArtworkTable $artworkTable;
    private OrderTable $orderTable;
    private SessionInterface $session;
    private Router $router;

    public function __construct(Renderer $renderer,
                                ArtistsTable $artistsTable,
                                ArtworkTable $artworkTable,
                                OrderTable $orderTable,
    SessionInterface $session,
    Router $router

    )
    {

        $this->renderer = $renderer;
        $this->artistsTable = $artistsTable;
        $this->artworkTable = $artworkTable;
        $this->orderTable = $orderTable;
        $this->session = $session;
        $this->router = $router;
    }

    public function __invoke(ServerRequestInterface $request): string|RedirectResponse
    {
        $this->renderer->addGlobal("viewPath", "@artists/profile");
        if($request->getMethod() === "DELETE") {
            return $this->delete($request);
        }
        if(str_ends_with($request->getUri()->getPath(), "edit")) {
            return $this->edit($request);
        }
        return $this->profile($request);
    }

    public function profile(ServerRequestInterface $request): string
    {
        $id = $request->getAttribute("id");
        try {
            $user = $this->artistsTable->findById($id);
        } catch (NoRecordException $e) {

        }
        $user_artworks = $this->artworkTable->makeQuery()
            ->select("artwork.*")
            ->where("artist_id = :id")
            ->params([":id" => $id])
            ->fetchAll();
        [$orders,$summary] = $this->getOrdersFromArtists($id, $user_artworks);

        return $this->renderer->render("@artists/profile/index", compact("user", "user_artworks", "orders", "summary"));
    }

    private function getOrdersFromArtists(int $id, QueryResult $artistArtworks): array
    {
        $order_ids = [];
        foreach ($artistArtworks as $artwork) {
            $order_ids[] = $artwork->orderId;
        }
        $order_ids = array_unique(array_filter($order_ids));
        if (count($order_ids) > 0) {
            $ordersResult = $this->orderTable->findByArtworks($order_ids)->fetchAll();
            $order_artworks = $this->artworkTable
                ->makeQuery()
                ->where("order_id IN (" . implode(",", $order_ids) . ")")
                ->where("artist_id = :id")
                ->params([":id" => $id])
                ->fetchAll();
            $orders = array_map(function ($order) use ($order_artworks) {
                $artworks = [];
                foreach ($order_artworks as $artwork) {
                    if ($artwork->orderId == $order->id) {
                        $artworks[] = $artwork;
                    }
                }
                return [
                    'order' => $order,
                    "artworks" => $artworks
                ];
            }, iterator_to_array($ordersResult));
            return [
                $orders,
                ["revenue" => array_sum(array_column(iterator_to_array($order_artworks), "price")),
                "total" => count($order_artworks)]
            ];

        }
        return [[], ["revenue" => 0, "total" => 0]];
    }

    public function edit(ServerRequestInterface $request): string|RedirectResponse
    {
        $errors = null;
        $user = $this->artistsTable->findById($request->getAttribute("id"));
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
                        $this->artistsTable->getTable(),
                        $this->artistsTable->getPdo(),
                        $user->id,
                    )
                    ->exists("email",
                            $this->artistsTable->getTable(),
                        $this->artistsTable->getPdo(),
                        $user->id
                    );
                $errors = $validator->getErrors();
                if(count($errors) === 0) {
                    $this->artistsTable->update($user->id, $params);
                    (new FlashService($this->session))->success("Profil modifié avec succès");
                    $path = $this->router->generateUri("artists.profile", ["id" => $user->id]);
                    return new RedirectResponse($path);
                }
                (new FlashService($this->session))->error("Il manque des informations pour le profil");
            }
        }
        return $this->renderer->render("@artists/profile/edit", compact("user", "errors"));

    }

    public function delete(ServerRequestInterface $request): string|ResponseInterface
    {
        $id = $request->getAttribute("id");
        $this->artistsTable->delete($id);
        (new FlashService($this->session))->success("Profil supprimé avec succès");
        return new RedirectResponse("/");
    }
}