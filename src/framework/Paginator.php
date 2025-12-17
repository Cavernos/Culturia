<?php namespace G1c\Culturia\framework;
use G1c\Culturia\framework\Database\PaginatedQuery;

use IteratorAggregate;
use JsonSerializable;
use Traversable;

class Paginator implements IteratorAggregate, JsonSerializable {
    private int $perPage;
    private PaginatedQuery $query;
    private int $currentPage = 1;
    private int $totalPages = 1;
    private int $totalResults;

    public function __construct(PaginatedQuery $query)
    {
        $this->query = clone $query;
        $this->totalResults = $this->query->getNbResults();

    }

    public function setMaxPerPage(int $perPage): Paginator
    {
        $this->perPage = $perPage;
        $this->totalPages =  ceil($this->totalResults/$this->perPage);
        return $this;
    }
    public function setCurrentPage($currentPage): Paginator
    {
        $this->currentPage = $currentPage;
        if ($this->currentPage > $this->totalPages) {
            $this->currentPage = 1;
        }
        return $this;
    }

    public function next(): int
    {

        if ($this->currentPage < $this->totalPages) {
            $nextPage = $this->currentPage + 1;
        } else {
            $nextPage = $this->totalPages;
        }
        return $nextPage;
    }

    public function previous(): int {
        if ($this->currentPage > 1){
            $previousPage = $this->currentPage - 1;
        } else {
            $previousPage = 1;
        }
        return $previousPage;
    }

    public function getRecords()
    {
        return $this->query->getSlice(($this->currentPage-1)*$this->perPage, $this->perPage);
    }

    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    public function jsonSerialize(): mixed
    {
        $results = $this->getRecords();
        if ($results instanceof Traversable) {
            return iterator_to_array($results);
        }
        return $results;
    }

    public function getIterator(): Traversable
    {
        $results = $this->getRecords();
        if ($results instanceof \Iterator) {
            return $results;
        }
        if ($results instanceof IteratorAggregate){
            return $results->getIterator();
        }
        return new \ArrayIterator($results);
    }
}