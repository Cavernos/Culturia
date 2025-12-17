<?php namespace G1c\Culturia\framework;
use G1c\Culturia\framework\Database\PaginatedQuery;

class Paginator {
    private $perPage;
    private $query;
    private $currentPage = 1;

    private $totalResults;
    public function __construct(PaginatedQuery $query)
    {
        $this->query = clone $query;
        $this->totalResults = $this->query->getNbResults();
    }

    public function setMaxPerPage($perPage): Paginator
    {
        $this->perPage = $perPage;
        return $this;
    }
    public function setCurrentPage($currentPage): Paginator
    {
        $this->currentPage = $currentPage;
        if ($this->currentPage > ceil($this->totalResults/$this->perPage) || !is_int($this->currentPage)) {
            $this->currentPage = 1;
        }
        return $this;
    }

    public function getResults()
    {
        return $this->query->getSlice(($this->currentPage-1)*$this->perPage, $this->perPage);
    }

}