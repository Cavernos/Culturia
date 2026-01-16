<?php

namespace G1c\Culturia\app\Shop\model;

use G1c\Culturia\framework\Model;

class OrderModel extends Model
{
    public $id;
    public  $order_date;

    public $previsionnal_delivery;

    public $client_adress;
    public $client_id;
}