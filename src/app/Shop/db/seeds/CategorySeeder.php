<?php

namespace G1c\Culturia\app\Shop\db\seeds;

use G1c\Culturia\framework\Database\Migrator\Seeder;

class CategorySeeder extends Seeder
{
    protected $tableName = 'category';
    public function run(): void
    {
        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                "name" => "Catégorie ". $i + 1,
                "description" => "Description de la catégorie". $i + 1,
                "avatar" => "/assets/img/category_". (rand(0, 100) % 10 + 1).".png",
            ];
        }
        $this->table()->insert($data)->save();
    }
}