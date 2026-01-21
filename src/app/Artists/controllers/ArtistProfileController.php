<?php

namespace G1c\Culturia\app\Artists\controllers;


use G1c\Culturia\app\Artists\table\ArtistsTable;
use G1c\Culturia\app\Shop\table\ArtworkTable;
use G1c\Culturia\app\Shop\table\OrderTable;
use G1c\Culturia\framework\Database\NoRecordException;
use G1c\Culturia\framework\Database\QueryResult;
use G1c\Culturia\framework\Renderer;
use Psr\Http\Message\ServerRequestInterface;

class ArtistProfileController
{
    private Renderer $renderer;
    private ArtistsTable $artistsTable;
    private ArtworkTable $artworkTable;
    private OrderTable $orderTable;

    public function __construct(Renderer $renderer,
                                ArtistsTable $artistsTable,
                                ArtworkTable $artworkTable,
                                OrderTable $orderTable)
    {

        $this->renderer = $renderer;
        $this->artistsTable = $artistsTable;
        $this->artworkTable = $artworkTable;
        $this->orderTable = $orderTable;
    }

    public function __invoke(ServerRequestInterface $request): string
    {
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
}