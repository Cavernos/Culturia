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
        $time = (new DateTime())->setTimestamp(rand(0, time()))->format('Y-m-d');
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                "name" => "Oeuvre ". $i + 1,
                "description" => "Description de l'oeuvre ". $i + 1,
                "creation_date" => $time,
                "modification_date" => $time,
                "price" => rand(100, 5000) * $i,
                "image" => "/assets/img/oeuvre_". (rand(0, 100) % 4 + 1).".png",
                "artist_id" => 1
            ];
        }
        $this->table()->insert($data)->save();
    }
}