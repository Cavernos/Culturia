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

    public function findList(): array
    {
        $results = $this->pdo->query("SELECT * FROM $this->table")->fetchAll(PDO::FETCH_NUM);
        $list = [];
        foreach ($results as $result) {
            $list[$result[0]] = $result[1];
        }
        return $list;

    }

    public function makeQuery(): Query {
        return (new Query($this->pdo))
            ->from($this->table)
            ->into($this->entity);
    }

    public function update(int $id, array $params): bool
    {
        $fieldQuery = $this->buildFieldQuery($params);
        $params['id'] = $id;
        $statement = $this->pdo->prepare("UPDATE $this->table SET $fieldQuery WHERE id = :id");
        return $statement->execute($params);
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
    public function delete(int $id): bool
    {
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id = ?");
        return $statement->execute([$id]);
    }

    public function buildFieldQuery(array $params): string
    {
        return join(', ', array_map(function ($field) {
            return "$field = :$field";
        }, array_keys($params)));
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