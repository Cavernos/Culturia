<?php

namespace G1c\Culturia\app\Shop\table;

use G1c\Culturia\app\Shop\model\ArtworkModel;
use G1c\Culturia\app\Shop\model\OrderModel;
use G1c\Culturia\framework\Database\Query;
use G1c\Culturia\framework\Database\Table;

class OrderTable extends Table
{
    protected $table = "orders";
    protected $entity = OrderModel::class;
    public function findByArtistsId(int $artistId): Query
    {
        return $this->makeQuery()
            ->select("orders.*", "artwork.*")
            ->join("artwork", "artwork.order_id = orders.id")
            ->where("artwork.artist_id = :artistId")->params([":artistId" => $artistId])
            ;
    }


}