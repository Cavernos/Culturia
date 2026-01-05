<?php

namespace G1c\Culturia\framework\Controllers;

use G1c\Culturia\framework\Database\Table;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Router\Router;


class CrudController
{
    use RouterAwareController;

    private Renderer $renderer;
    protected Table $table;
    private Router $router;

    protected string $viewPath;

    protected string $routePrefix;

    public function __construct(Renderer $renderer, Table $table, Router $router)
    {

        $this->renderer = $renderer;
        $this->table = $table;
        $this->router = $router;
    }
    public function __invoke($request, $params): string
    {
        $this->renderer->addGlobal('viewPath', $this->viewPath);
        $this->renderer->addGlobal('routePrefix', $this->routePrefix);
        if($request["REQUEST_METHOD"] == "DELETE"){
            return $this->delete($params[0]);
        }
        if (str_ends_with($request["REQUEST_URI"], 'new')){
            return $this->create();
        }
        if (isset($params[0])){
            return $this->edit($params[0]);
        }
        return $this->index();
    }

    public function index(): string
    {
        $table = $this->table->getTable();
        $items = $this->table->makeQuery();
        return $this->renderer->render("$this->viewPath/index", compact("items"));

    }

    public function create(): string {

    }

    public function delete($id): string {
        return "";
    }
    public function edit($id): string {}

}