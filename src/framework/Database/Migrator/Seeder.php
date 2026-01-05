<?php

namespace G1c\Culturia\framework\Database\Migrator;

use G1c\Culturia\framework\Database\Migrator\Table\MigrationTable;
use PDO;

class Seeder
{
    protected $tableName = "";


    public function __construct(PDO $pdo)
    {

        $this->pdo = $pdo;
    }

    public function table(?string $name = ""): MigrationTable
    {
        if(!empty($this->tableName)){
            return (new MigrationTable($this->tableName, $this->pdo));
        }
        return (new MigrationTable($name, $this->pdo));
    }

}