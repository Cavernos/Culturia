<?php

namespace G1c\Culturia\framework\Database\Migrator;

class MigrationRecorder
{
    private array $actions = [];
    public function record(string $action, ?array $params = [])
    {
        $this->actions[] = ["action" => $action, "params" => $params];
    }

    public function getActions(): array
    {
        return $this->actions;
    }
}