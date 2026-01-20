<?php

namespace G1c\Culturia\app\Artists\controllers;


use G1c\Culturia\app\Artists\table\ArtistsTable;
use G1c\Culturia\app\Shop\table\ArtworkTable;
use G1c\Culturia\app\Shop\table\OrderTable;
use G1c\Culturia\framework\Database\NoRecordException;
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
        $order_ids = [];
        foreach ($user_artworks as $artwork) {
            $order_ids[] = $artwork->orderId;
        }
        $order_ids = array_unique($order_ids);
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
                if($artwork->orderId == $order->id){
                    $artworks[] = $artwork;
                }
            }
            return [
                'order' => $order,
                "artworks" => $artworks
            ];
        }, iterator_to_array($ordersResult));
        $summary["revenue"] = array_sum(array_column(iterator_to_array($order_artworks), "price"));
        $summary["total"] = count($order_artworks);
        return $this->renderer->render("@artists/profile/index",
            compact("user", "user_artworks", "orders", "summary"));
    }
}