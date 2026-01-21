<?php

namespace G1c\Culturia\framework\Database\Migrator\Table;

use G1c\Culturia\framework\Database\Migrator\MigrationRecorder;
use PDO;

class MigrationTable
{
    private $tableName;

    private $fields;

    private $foreignKeys;

    private $method;

    private $inserts;

    private $params;

    private $update;

    private $pdo;
    private $recorder;

    public function __construct(string $tableName, PDO $pdo, ?MigrationRecorder $recorder = null)
    {

        $this->tableName = $tableName;
        $this->pdo = $pdo;
        $this->recorder = $recorder;

    }
    public function hasTable(): bool
    {
        $query = $this->pdo->prepare("
            SELECT COUNT(*) FROM INFORMATION_SCHEMA.tables WHERE table_name = :tableName AND table_schema = DATABASE()
        ");
        $query->execute([":tableName" => $this->tableName]);
        return $query->fetchColumn() > 0;
    }
    public function hasColumn($name): bool
    {
        if($this->hasTable()){
            $query = $this->pdo->prepare("SHOW COLUMNS FROM `$this->tableName` LIKE :column");
            $query->execute([":column" => $name]);
            return $query->rowCount() > 0;
        }
        return false;
    }

    public function addColumn($name, $type, ?array $params = []): MigrationTable {
        if(!isset($param["PRIMARY KEY"])){
            $this->recorder->record("addColumn", compact('name', 'type', 'params'));
        }

        if(!$this->hasColumn($name)){
            $query = "$name $type";
            foreach ($params as $param => $value) {
                if ($value){
                    $query = $query . " $param";
                } elseif(strtoupper($param) == "NULL") {
                    $query = $query . " NOT " . $param;
                }
            }
            $this->fields[] = $query;
        }

        return $this;
    }
    public function removeColumn($name, $type, ?array $params = []): MigrationTable
    {
        if($this->hasTable() && $this->hasColumn($name)){
            $this->fields[] = $name;
            $this->update("DROP ");
        }
        return $this;

    }

    public function addForeignKey($field, $destTable, $destField, ?array $params = null): MigrationTable
    {
        $this->recorder->record("addForeignKey", compact('field','destTable', 'destField', 'params'));
        $query = "CONSTRAINT fk_$destTable"."_"."$destField FOREIGN KEY ($field) REFERENCES $destTable ($destField)";
        if (!is_null($params)) {
            foreach ($params as $key => $value) {
                $query = $query . " ON $key $value";
            }
        }
        $this->foreignKeys[] = $query;
        return $this;

    }

    public function removeForeignKey($field, $destTable, $destField, ?array $params = null): MigrationTable
    {
        $query = "FOREIGN KEY fk_". $destTable."_".$destField;
        $this->foreignKeys[] = $query;
        $this->update("DROP ");
        return $this;

    }
    public function create() {
        $this->recorder->record("create");
        $this->method = "CREATE TABLE IF NOT EXISTS ";
        return $this->save();

    }

    public function drop()
    {
        $this->method = "DROP TABLE IF EXISTS";
        return $this->save();
    }
    public function __toString(): string
    {
        if(!empty($this->method)){
            $parts[] = $this->method;
        }
        $parts[] = "$this->tableName";
        if(!empty($this->inserts)){
            $columns = array_unique(array_merge(...array_map('array_keys',$this->inserts)));
            $parts[] = "(" . join(", ",$columns) . ") VALUES";
            $values = array_map(function ($index) use ($columns) {
                return "(" . implode(", ", array_map(function ($col) use ($index) {
                    return ":" . $col . '_' . $index;
                    }, $columns)) . ")";
            }, array_keys($this->inserts));
            $parts[] = join(", ", $values);

        }

        if (!empty($this->fields)) {
            $parts[] = '(' . join(", ", array_values($this->fields)) . ")";
        }
        if(!empty($this->foreignKeys)) {
            $parts[] = join(", ", $this->foreignKeys);

        }
        if(!empty($this->update)){
            $parts[] = join(", ", $this->update);
        }

        return join(" ", $parts);


    }
    private function prefixString($array, $prefix): string {
        $tmp = [];
        foreach ($array as $key) {
            $tmp[] = $prefix .  $key;
        }
        return join(", ", $tmp);
    }

    public function insert(array $datas): MigrationTable
    {
        $i = 0;
        foreach ($datas as $data) {
            $this->inserts[] = $data;
            foreach ($data as $key => $value) {
                $this->params[":".$key. "_" . $i] = $value;

            }
            $i++;
        }
        $this->method = "INSERT IGNORE INTO";
       return $this;

    }
    public function update($prefix = "ADD ")
    {
        $this->method = "ALTER TABLE";
        if(!empty($this->fields)){
            $this->update[] = $this->prefixString($this->fields, $prefix);
            $this->fields = [];
        }
        if(!empty($this->foreignKeys)){
            $this->update[] = $this->prefixString($this->foreignKeys, $prefix);
            $this->foreignKeys = [];
        }
        return $this;

    }
    public function save()
    {
        $query = $this->__toString();
        if(!empty($this->params)){
            return $this->pdo->prepare($query)->execute($this->params);
        }
        return $this->pdo->prepare($query)->execute();

    }
}