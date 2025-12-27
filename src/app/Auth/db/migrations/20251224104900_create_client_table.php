<?php

namespace G1c\Culturia\app\Auth\db\migrations;

use G1c\Culturia\framework\Database\Migrator\Migrator;

class ClientMigrations extends Migrator
{
    protected $tableName = "clients";
    public function run() {
        $table = $this->table()
            ->addColumn('username', "VARCHAR(128)")
            ->addColumn('avatar', "VARCHAR(128)")
            ->addColumn('email', "VARCHAR(128)")
            ->addColumn('password', "TEXT")
            ->addColumn("inscription_date", "DATE")
            ->addColumn("modification_date", "DATE")
            ->create();
    }

}