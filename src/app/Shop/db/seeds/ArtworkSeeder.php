<?php

namespace G1c\Culturia\app\Shop\db\seeds;

use DateTime;
use G1c\Culturia\framework\Database\Migrator\Seeder;

class ArtworkSeeder extends Seeder
{
    protected $tableName = 'artwork';
    public function run(): void
    {
        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                "name" => "Oeuvre ". $i + 1,
                "description" => "Description de l'oeuvre ". $i + 1,
                "creation_date" => "2025-06-30",
                "modification_date" => "2025-06-30",
                "price" => $i * 100 + 3000,
                "image" => "/assets/img/oeuvre_". (rand(0, 100) % 4 + 1).".png",
                "artist_id" => 1
            ];
        }
        $this->table()->insert($data)->save();
    }
}