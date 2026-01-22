<?php

namespace G1c\Culturia\app\Shop\table;

use G1c\Culturia\app\Shop\model\ArtworkModel;
use G1c\Culturia\app\Shop\model\OrderModel;
use G1c\Culturia\framework\Database\Query;
use G1c\Culturia\framework\Database\QueryResult;
use G1c\Culturia\framework\Database\Table;

class OrderTable extends Table
{
    protected $table = "orders";
    protected $entity = OrderModel::class;
    public function findByArtworks(array $ids): Query
    {
        return $this->makeQuery()
            ->where("orders.id IN (" . implode(", ", array_filter($ids)) . ")")
            ->select("orders.*", "clients.username", "clients.avatar")
            ->order("order_date DESC")
            ->join("clients", "orders.client_id = clients.id");
    }


}