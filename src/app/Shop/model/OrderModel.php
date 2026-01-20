<?php

namespace G1c\Culturia\app\Shop\model;

use G1c\Culturia\framework\Model;

class OrderModel extends Model
{
    public $id;
    public  $orderDate;

    public $previsionnalDelivery;

    public $clientAdress;
    public $clientId;
}