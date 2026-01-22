<?php

namespace G1c\Culturia\app\Shop\model;

use DateTime;
use G1c\Culturia\framework\Model;

class OrderModel extends Model
{
    public $id;
    public  $orderDate;

    public $previsionnalDelivery;

    public $clientAddress;
    public $clientId;

    public function setOrderDate(string $orderDate)
    {
        $this->orderDate = new DateTime($orderDate);
    }
}