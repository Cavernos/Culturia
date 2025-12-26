<?php

namespace G1c\Culturia\framework\Database\Migrator;

class MigrationReverser
{
    public function reverse(array $actions): array
    {
        $reversed = [];
        foreach (array_reverse($actions) as $action) {
            if (isset($action["action"])) {
                if(str_starts_with($action["action"], "add")){
                    $action["action"] = str_replace("add", "remove", $action["action"]);
                } elseif ($action["action"] === "create"){
                    $action["action"] = "drop";
                }
            }
            $reversed[] = $action;
        }


        return $reversed;
    }

}