<?php namespace G1c\Culturia\framework\Database\Query;

class Query {
    
    /**
     * @var PDO
     */
    private $pdo;

    private $select;

    private $from;

    private $where;


    function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function select(string ...$fields): self{
        $this->select = $fields;
        return $this;
    }

    public function from(string $table, ?string $alias= null): self{
        if ($alias){
            $this->from[$table] = $alias;
        } else {
            $this->from = [$table];
        }
        return $this;

    }
    
    public function where(string ...$conditions): self{
        $this->where = array_merge($this->where, $conditions);
        return $this;
    }


}

?>