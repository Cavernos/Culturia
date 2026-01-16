<?php

namespace G1c\Culturia\app\Shop\db\seeds;

use DateTime;
use G1c\Culturia\framework\Database\Migrator\Seeder;

class OrderSeeder extends Seeder
{
    protected $tableName = 'orders';
    public function run(): void
    {
        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $time = (new DateTime())->setTimestamp(rand(0, time()))->format('Y-m-d');
            $data[] = [
                "order_date" => $time,
                "client_address" => $i * 33 . "Ter 79800",
                "previsionnal_delivery" => $time,
            ];
        }
        $this->table()->insert($data)->save();
    }
}