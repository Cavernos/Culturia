<?php

namespace G1c\Culturia\framework\Controllers;

use G1c\Culturia\framework\Database\Hydrator;
use G1c\Culturia\framework\Database\Table;
use G1c\Culturia\framework\Model;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Router\Router;
use G1c\Culturia\framework\Session\FlashService;
use G1c\Culturia\framework\Validator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


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
    public function __invoke(ServerRequestInterface $request, $params): string|ResponseInterface
    {
        $this->renderer->addGlobal('viewPath', $this->viewPath);
        $this->renderer->addGlobal('routePrefix', $this->routePrefix);
        if($request->getMethod() == "DELETE"){
            return $this->delete((int)$params[0]);
        }
        if (str_ends_with($request->getUri()->getPath(), 'new')){
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

    public function create(ServerRequestInterface $request): string|ResponseInterface {
        $errors = null;
        $item = $this->getNewEntity();
        if($request->getMethod() == "POST"){
            $validator = $this->getValidator($request->getParsedBody());
            if(!empty($validator->isValid())) {
                $this->table->insert($this->getParams($item));
                $this->flashService->success($this->flashMessages['create']);
                return $this->redirect(...$this->getRedirectPath($this->getParams($item)));

            }
            $errors = $validator->getErrors();
            Hydrator::hydrate($request->getParsedBody(), $item);
        }
        $params = $this->formParams(compact("item", "errors"));
        return $this->renderer->render("$this->viewPath/create", $params);
    }

    public function delete(int|Model $id): string|ResponseInterface {
        if(property_exists($id, "id")){
            $item = $id->id;
        } else {
            $item = $id;
        }
        $this->table->delete($item);
        $this->flashService->error($this->flashMessages['delete']);
        return $this->redirect(...$this->getRedirectPath($id));
    }
    public function edit(ServerRequestInterface $request): string|ResponseInterface {
        $item = $this->table->findById($request->getAttribute("id"));
        $errors = null;
        if($request->getMethod() === "POST") {
            $validator = $this->getValidator($request->getParsedBody());
            if(!empty($validator->isValid())) {
                $this->table->update($item->id, $this->getParams($item));
                $this->flashService->success($this->flashService['edit']);
                return $this->redirect(...$this->getRedirectPath($this->getParams($item)));
            }
            $errors = $validator->getErrors();
            Hydrator::hydrate($request->getParsedBody(), $item);
        }
        $params = $this->formParams(compact("item", "errors"));
        return $this->renderer->render("$this->viewPath/edit", $params);
    }

    protected function getValidator(ServerRequestInterface $request): Validator
    {
        return new Validator(array_merge($request->getParsedBody(), $request->getUploadedFiles()));
    }
    protected function getParams(ServerRequestInterface $request, $item): array
    {
        return array_filter($request->getParsedBody(), function ($key) {
           return in_array($key, []);
        }, ARRAY_FILTER_USE_KEY);
    }

    protected function getNewEntity(): array|Model
    {
        return [];
    }

    protected function getRedirectPath(array|Model|null $item = []): array
    {
        return [$this->routePrefix . ".index"];
    }
    protected function formParams(array $params): array
    {
        return $params;
    }



}