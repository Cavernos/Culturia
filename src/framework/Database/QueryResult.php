<?php namespace G1c\Culturia\framework\Database;

use ArrayAccess;
use Exception;
use Iterator;

class QueryResult implements ArrayAccess, Iterator, \Countable
{
    private array $records = [];
    private ?string $entity;
    private array $hydratedRecords = [];

    private int $index = 0;

    public function __construct(array $records,?string $entity = null)
    {
        $this->records = $records;
        $this->entity = $entity;
    }

    public function get(int $index): mixed
    {
        if ($this->entity){
            if (!isset($this->hydratedRecords[$index])){
                $this->hydratedRecords[$index] = Hydrator::hydrate($this->records[$index], $this->entity);
            }
            return $this->hydratedRecords[$index];
        }
        return $this->records[$index];
    }

    /**
     * @return mixed
     */
    public function current(): mixed
    {
        return $this->get($this->index);
    }

    public function next(): void
    {
        $this->index++;
    }

    public function key(): int
    {
        return $this->index;
    }

    public function valid(): bool
    {
        return isset($this->records[$this->index]);
    }

    public function rewind(): void
    {
        $this->index = 0;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
       return isset($this->records[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }


    /**
     * @param mixed $offset
     * @param $value
     * @return mixed
     * @throws Exception
     */
    public function offsetSet(mixed $offset, $value): void
    {
        throw new Exception("Il n'est pas possible de modifier un enregistrement");

    }


    /**
     * @param mixed $offset
     * @return mixed
     * @throws Exception
     */
    public function offsetUnset(mixed $offset): void
    {
        throw new Exception("Il n'est pas possible de modifier un enregistrement");
    }

    public function count(): int
    {
        return count($this->records);
    }
}