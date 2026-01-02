<?php namespace G1c\Culturia\app\Shop\controllers;

use G1c\Culturia\app\Shop\table\ArtworkTable;
use G1c\Culturia\framework\Logger;
use G1c\Culturia\framework\Renderer;
use G1c\Culturia\framework\Router\Router;
use G1c\Culturia\framework\Session\SessionInterface;

class ShopController {
    private $renderer;
    private $table;
    private Router $router;
    private Logger $logger;

    public function __construct(Logger $logger, Renderer $renderer,
                                Router $router,
                                ArtworkTable $table,
    ) {
        $this->renderer = $renderer;
        $this->table = $table;
        $this->router = $router;
        $this->logger = $logger;
    }
    

    public function index(){
        $artworks = $this->table->findPublic()->paginate(16, $_GET["p"] ?? 1);

        return $this->render('@shop/shop', compact("artworks"));
    }
    public function view($slug, $id) {
        $artwork = $this->table->findPublicId($id)->fetchOrFail();
        $similar_artworks = $this->table->findPublic()->limit(4)->fetchAll();
        return $this->render('@shop/show', compact("artwork", "similar_artworks"));
        
    }

    private function render(string $view, $args = []): string
    {
        $this->logger->info("Rendering $view");
        return $this->renderer->render($view, $args);
    }

    public function filter()
    {
        $params = $_POST;
        $artworks = $this->table->findPublic();
        if(array_key_exists('reset', $params)){
            if($params["reset"] == 1) {
                foreach ($params as $key => $value) {
                    $params[$key] = "0";
                }
                $artworks = $artworks->paginate(16, $_GET["p"] ?? 1);
                return $this->render("@shop/shop", compact("params", "artworks"));
            }
            unset($params["reset"]);
        }
        $filter = [];
        uksort($params, function ($a, $b) {
            $aEndWithBtn = str_ends_with($a, "_btn");
            $bEndWithBtn = str_ends_with($b, "_btn");
            $aBase = $aEndWithBtn ? str_replace("_btn", "", $a) : $a;
            $bBase = $bEndWithBtn ? str_replace("_btn", "", $b) : $b;
            if($aBase !== $bBase) {
                return strcmp($aBase, $bBase);
            }

            if($aEndWithBtn && !$bEndWithBtn) return -1;
            if(!$aEndWithBtn && $bEndWithBtn) return 1;
            return 0;
        });
        foreach ($params as $key => $value) {
            if(str_contains($key, "_btn")){
                $name = str_replace("_btn", "", $key);
                $params[$name] = ($params[$name] == 1) ? "0" : "1";
            } else {
                if($params[$key] == 0) {
                    $filter[$key] = "ASC";
                } else {
                    $filter[$key] = "DESC";
                }
            }

        }
        $order = join(', ', array_map(fn($k, $v) => "$k $v", array_keys($filter), $filter));
        $order = str_replace("artists", "artists.id", $order);
        var_dump($order);
        $artworks = $artworks->order($order)->paginate(16, $_GET["p"] ?? 1);
        return $this->render("@shop/shop", compact("params", "artworks"));
    }
}