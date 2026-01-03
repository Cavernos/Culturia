<?php

namespace G1c\Culturia\framework\Database;

use PDO;
use stdClass;

class Table
{
 private PDO $pdo;
    /**
     * @var ?string
     */
    protected $table;
    protected $entity = stdClass::class;

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @throws NoRecordException
     */
    public function findById(int $id){
        return $this->makeQuery()->where("id = $id")->fetchOrFail();
    }
    public function findByParams(string $condition, array $params)
    {

        return $this->makeQuery()->where($condition)->params($params)->fetchOrFail();
    }

    public function makeQuery(): Query {
        return (new Query($this->pdo))
            ->from($this->table)
            ->into($this->entity);
    }
    public function insert(array $params): bool
    {
        $fields = array_keys($params);
        $values = join(", ", array_map(function ($field) {
            return ":". $field;
        }, $fields));
        $fields = implode(", ", $fields);
        $statement = $this->pdo->prepare("INSERT INTO $this->table ($fields) VALUES ($values)");
        return $statement->execute($params);
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    /**
     * @return mixed
     */
    public function getTable()
    {
        return $this->table;
    }

    public function getEntity(): string
    {
        return $this->entity;
    }
}