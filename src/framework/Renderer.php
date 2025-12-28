<?php namespace G1c\Culturia\framework;
use G1c\Culturia\framework\Renderer\RendererExtensionInterface;

class Renderer {
    const DEFAULT_NAMESPACE = '__MAIN';
    private array $paths = [];
    private array $globals = [];


    private array $extensionsCallbacks = [];

    public function addPath(string $namespace, ?string $path = null): void {
        if (is_null($path)){
            $this->paths[self::DEFAULT_NAMESPACE] = $namespace;                
        } else {
            $this->paths[$namespace] = $path;
        }
    }

    public function addExtension(RendererExtensionInterface $extension): void
    {
        $this->extensionsCallbacks[$extension->getFunctions()->getName()] = $extension->getFunctions()->getFunction();
    }

    public function addGlobal(string $key, mixed $value): void {
        $this->globals[$key] = $value;
    }

    public function render(string $view, array $params = []): string{
        if($this->hasNamespace($view)){
            $path = $this->replaceNamespace($view). ".php";
        } else {
            $path = $this->paths[self::DEFAULT_NAMESPACE] . DIRECTORY_SEPARATOR . $view . ".php";
        }
        ob_start();
        extract($this->globals);
        extract($params);
        extract($this->extensionsCallbacks);
        require($layout_path);
        return ob_get_clean();
    }

    private function hasNamespace(string $view): bool{
        return $view[0] === '@';
    }
    private function getNamespace(string $view): string {
        return substr($view, 1, strpos($view, "/") -1);
    }

    private function replaceNamespace(string $view): string{
        $namespace = $this->getNamespace($view);
        return str_replace('@'. $namespace, $this->paths[$namespace], $view);
    }
}