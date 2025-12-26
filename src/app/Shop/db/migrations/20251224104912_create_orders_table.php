<?php

namespace G1c\Culturia\app\Shop\db\migrations;

use G1c\Culturia\framework\Database\Migrator\Migrator;

class OrderMigrations extends Migrator
{
    protected $tableName = "orders";
    public function run()
    {
        $this->table()
            ->addColumn('order_date', 'DATE')
            ->addColumn("client_address", "VARCHAR(128)")
            ->addColumn("previsionnal_delivery", "DATE")
            ->addColumn("artwork_id", "INT")
            ->addColumn("client_id", "INT")
            ->create();
    }
}