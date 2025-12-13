<?php namespace G1c\Culturia\framework;

use Exception;
use ReflectionClass;

class Container {
    
    private $contents = [];
    private $instances = [];
    private static $_instance;

    public static function getInstance(?string $definition = null){  
        if(is_null(self::$_instance)){
            self::$_instance = new Container($definition);
        }
        return self::$_instance;
    }

    public function __construct(?string $definition)
    {
       $this->contents =  require($definition);
    }

    public function addDefinition(string $definition)
    {
        $contents =  require($definition);
        foreach($contents as $key => $property){
            $this->set($key, $property);
        }
    }

    public function get(mixed $key): mixed {  
        if (!isset($this->contents[$key])) {
            if(class_exists($key)){
                if (!isset($this->instances[$key])){
                    $this->instances[$key] = $this->resolve($key);
                }
                return $this->instances[$key];
            }
            return null;
        }
        return $this->contents[$key];
    }
    public function set(mixed $key, mixed $value) : void {
        if(is_callable($value)){
            $this->contents[$key] =  $value();
        } else {
            $this->contents[$key] = $value;
        }
        
        
    }
    public function resolve(string $class_name, ?string $constructor_parameter_alias = null) {
        $reflected_class = new ReflectionClass($class_name);
        if($reflected_class->isInstantiable()){
            $constructor = $reflected_class->getConstructor();
            if ($constructor){
                $parameters = $constructor->getParameters();
                $constructor_parameters = [];
                foreach($parameters as $parameter){
                        if(!$parameter->getType()->isBuiltin()){
                             $constructor_parameters[] = $this->get($parameter->getType()->getName());
                        } else {
                            if (!is_null($constructor_parameter_alias)){
                                $constructor_parameters[] = $this->get($constructor_parameter_alias);
                            } else {
                                $constructor_parameters[] = $parameter->getDefaultValue();
                            }    
                        }    
                }
                return $reflected_class->newInstanceArgs($constructor_parameters);
            }else {
                return $reflected_class->newInstance();
            }
        } else {
            throw new Exception($class_name . "is not instanciable");
        }
    }
}