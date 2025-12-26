<?php

use G1c\Culturia\framework\Database\Migrator\Migrator;
require "public/index.php";

$modules = $app->getModules();
$pdo = $app->getContainer()->get(PDO::class);
$migrations = [];
$seeds = [];

foreach ($modules as $module) {
    $migrations[] = $module::MIGRATIONS;
    $seeds[] = $module::SEEDS;
}
function getFilesFromArray($definitions): array
{
    $file_list = [];
    foreach ($definitions as $definition) {
        if(!is_null($definition)) {
            if(is_dir($definition)) {
                $files = array_diff(scandir($definition), [".", ".."]);
                foreach ( $files as $file) {
                    $file_list[] = $definition . "/" . $file;
                }
            } elseif (is_file($definition)) {
                $file_list[] = $definition;
            }

        }
    }
    usort($file_list, function ($a, $b) {
        $timestampA = (int) strtok(basename($a), "_");
        $timestampB = (int) strtok(basename($b), "_");
        return $timestampA <=> $timestampB;
    });
    return $file_list;

}
function getClassesFromFiles($files): array
{
    $classNames = [];
    foreach ($files as $file) {
        $classes = array_values(get_declared_classes());
        require_once $file;
        $newClasses =  array_values(get_declared_classes());
        foreach (array_diff( $newClasses, $classes) as $className) {
            if(is_subclass_of($className, Migrator::class)){
                $classNames[] = $className;
            }
        }

    }
    return $classNames;

}
function createInstances($migrations, $pdo)
{
    $instances = [];
    $classNames = getClassesFromFiles(getFilesFromArray($migrations));
    foreach ($classNames as $name) {
        $instances[] = new $name($pdo);
    }
    return $instances;

}
function migrate($instances)
{
    foreach ($instances as $name) {
        if (method_exists($name, "up")) {
            $name->up();
        } else {
            return false;
        }
    }
    return true;
}

function rollback($instances): bool
{
    foreach (array_reverse($instances) as $instance) {
        if (method_exists($instance, "down")) {
            $instance->down();
        } else {
            return false;
        }
    }
    return true;

}


function create(array $definitions)
{
    echo "Choisissez un module de génération : ";
    $module_name = ucfirst(trim(fgets(STDIN)));
    foreach ($definitions as $definition) {
        if(!is_null($definition) && preg_match("#(?:(?<=/)|(?<=\\\\)|^)($module_name)(?:(?=/)|(?=\\\\)|$)#i", $definition, $matches)) {

            $path = $definition . "/";
        }
    }
    $date = (new DateTime())->format("YmdHis");
    echo "Choisissez un nom pour votre migration : ";
    $name = trim(fgets(STDIN));
    $name = strtolower($name);
    echo "Choisissez quelle table voulez-vous créer : ";
    $tableName = trim(fgets(STDIN));
    $filename = $date . "_" . $name . ".php";
    $filePath = $path ?? __DIR__ . "/db/migrations/";
    if(!is_dir($filePath)) {
        mkdir($filePath, 0755, true);
    }
    if(!file_exists($filePath . $filename)) {
        $template = file_get_contents(__DIR__ . "/migration_template.php");
        $className = preg_replace_callback('/(^|_)([a-z])/', fn($m) => strtoupper($m[2]), $name);
        $template = str_replace("{{className}}", $className, $template);
        $content = str_replace("{{tableName}}", $tableName, $template);
        file_put_contents($filePath . $filename, $content);
    }


    return true;
}
$migrators = createInstances($migrations, $pdo);
switch ($argv[1]) {
    case "create":
        return create($migrations);
    case "migrate":
        return migrate($migrators);
    case "rollback":
        return rollback($migrators);
    default:
        echo "Aucun argument ne correspond à votre demande";

}


