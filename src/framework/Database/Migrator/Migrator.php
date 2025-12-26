<?php

namespace G1c\Culturia\framework\Database\Migrator;

use Exception;
use G1c\Culturia\framework\Database\Migrator\Table\MigrationTable;
use PDO;
use ReflectionClass;

abstract class Migrator
{

    protected $tableName = "";

    private PDO $pdo;

    private MigrationTable $table;
    private MigrationRecorder $recorder;

    public function __construct(PDO $pdo)
    {

        $this->pdo = $pdo;
        $this->recorder = new MigrationRecorder();
        $this->table = new MigrationTable($this->tableName, $this->pdo, $this->recorder);
    }

    public function table(): MigrationTable
    {
        return $this->table;
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }
    public function up()
    {
        $this->store([$this, 'run']);
    }
    public abstract function run();

    public function down()
    {
        $reverser = new MigrationReverser();
        $filename = $this->getStorePath();
        if(file_exists($filename)) {
            $actions = json_decode(file_get_contents($filename), true);
        }
        $reversed_action = $reverser->reverse($actions ?? []);
        foreach ($reversed_action as $action) {
            if (method_exists($this->table, $action["action"])) {
                $this->table->{$action["action"]}(...$action["params"]);
            } else {
                throw new Exception("L'action " . $action["action"] . " n'est pas réversible");
            }
        }
        $this->table->save();
        if(file_exists($filename)) {
            unlink($filename);
        }

    }

    private function getStorePath(): string
    {
        $filename = str_replace( ".php", ".json", basename((new ReflectionClass($this))->getFileName()));
        $dirpath = "storage/migrations/";
        $filepath = $dirpath . $filename;
        if(!is_dir($dirpath)){
            mkdir($dirpath, 0755, true);
        }
        return $filepath;
    }

    public function store(callable $callback): void
    {

        $filepath = $this->getStorePath();
        if(!file_exists($filepath)) {
            $callback();
            file_put_contents($filepath, json_encode($this->recorder->getActions()));
        } else {
            echo "Migration déjà effectué ";
        }


    }
}