<?php

namespace G1c\Culturia\framework\Controllers;

use G1c\Culturia\framework\Database\Table;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Router\Router;


class CrudController
{
    use RouterAwareController;

    private Renderer $renderer;
    private Table $table;
    private Router $router;

    public function __construct(Renderer $renderer, Table $table, Router $router)
    {

        $this->renderer = $renderer;
        $this->table = $table;
        $this->router = $router;
    }
    public function __invoke()
    {
    return $this->index();
    }

    public function index()
    {
        $table = $this->table->getTable();
        $this->redirect("shop.index");

    }

    public function create(){

    }

    public function delete(){

    }
    public function update(){}

}