<?php

namespace G1c\Culturia\framework\Database;

class PaginatedQuery
{
    /**
     * @var Query
     */
    private $query;

    /**
     * @param Query $query
     */
    public function __construct(Query $query)
    {
        $this->query = $query;
    }

    /**
     * @return int
     */
    public function getNbResults(): int
    {
        return $this->query->count();
    }

    /**
     * @param int $offset
     * @param int $length
     * @return QueryResult
     */
    public function getSlice(int $offset, int $length): iterable
    {
        $query = clone $this->query;
        return $query->limit($length, $offset)->fetchAll();
    }
}