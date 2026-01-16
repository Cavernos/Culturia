<?php

namespace G1c\Culturia\framework\Controllers;

use G1c\Culturia\framework\Database\Hydrator;
use G1c\Culturia\framework\Database\Table;
use G1c\Culturia\framework\Model;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Router\Router;
use G1c\Culturia\framework\Session\FlashService;
use G1c\Culturia\framework\Validator;


class CrudController
{
    use RouterAwareController;

    private Renderer $renderer;
    protected Table $table;
    private Router $router;

    protected string $viewPath;

    protected string $routePrefix;

    protected array $flashMessages = [
        'create' => "L'élément a bien été créé",
        'edit' => "L'élément a bien été modifié",
        'delete' => "L'élément a bien été supprimé"
    ];
    private FlashService $flashService;

    public function __construct(Renderer $renderer,
                                Table $table,
                                FlashService $flashService,
                                Router $router)
    {

        $this->renderer = $renderer;
        $this->table = $table;
        $this->router = $router;
        $this->flashService = $flashService;
    }
    public function __invoke($request, $params): string
    {
        $this->renderer->addGlobal('viewPath', $this->viewPath);
        $this->renderer->addGlobal('routePrefix', $this->routePrefix);
        if($request["REQUEST_METHOD"] == "DELETE"){
            return $this->delete((int)$params[0]);
        }
        if (str_ends_with($request["REQUEST_URI"], 'new')){
            return $this->create($request);
        }
        if (isset($params[0])){
            return $this->edit($request, $params[0]);
        }
        return $this->index();
    }

    public function index(): string
    {
        $table = $this->table->getTable();
        $items = $this->table->makeQuery();
        return $this->renderer->render("$this->viewPath/index", compact("items"));

    }

    public function create($request): string {
        $errors = null;
        $item = $this->getNewEntity();
        if($request["REQUEST_METHOD"] == "POST"){
            $validator = $this->getValidator($_POST);
            if(!empty($validator->isValid())) {
                $this->table->insert($this->getParams($item));
                $this->flashService->success($this->flashMessages['create']);
                $this->redirect(...$this->getRedirectPath($this->getParams($item)));
                return "";
            }
            $errors = $validator->getErrors();
            Hydrator::hydrate($_POST, $item);
        }
        $params = $this->formParams(compact("item", "errors"));
        return $this->renderer->render("$this->viewPath/create", $params);
    }

    public function delete(int $id): string {
        $this->table->delete($id);
        $this->flashService->error($this->flashMessages['delete']);
        $this->redirect($this->routePrefix . '.index');
        return "true";
    }
    public function edit($request, $id): string {
        $item = $this->table->findById($id);
        $errors = null;
        if($request['REQUEST_METHOD'] === "POST") {
            $validator = $this->getValidator($_POST);
            if(!empty($validator->isValid())) {
                $this->table->update($item->id, $this->getParams($item));
                $this->flashService->success($this->flashService['edit']);
                $this->redirect(...$this->getRedirectPath($this->getParams($item)));
            }
            $errors = $validator->getErrors();
            Hydrator::hydrate($_POST, $item);
        }
        $params = $this->formParams(compact("item", "errors"));
        return $this->renderer->render("$this->viewPath/edit", $params);
    }

    protected function getValidator($request): Validator
    {
        return new Validator(array_merge($_POST, $_FILES));
    }
    protected function getParams($item): array
    {
        return array_filter($_POST, function ($key) {
           return in_array($key, []);
        }, ARRAY_FILTER_USE_KEY);
    }

    protected function getNewEntity(): array|Model
    {
        return [];
    }

    protected function getRedirectPath(array $item): array
    {
        return [$this->routePrefix . ".index"];
    }
    protected function formParams(array $params): array
    {
        return $params;
    }



}