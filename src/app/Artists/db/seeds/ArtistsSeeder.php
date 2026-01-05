<?php

namespace G1c\Culturia\app\Artists\db\seeds;

use DateTime;
use G1c\Culturia\framework\Database\Migrator\Seeder;

class ArtistsSeeder extends Seeder
{
    protected $tableName = 'artists';

    public function run(): void
    {
        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $time = (new DateTime())->setTimestamp(rand(0, time()))->format('Y-m-d');
            $data[] = [
                "username" => "Artiste " . $i + 1,
                "email" => "artiste_" . $i + 1 . "@culturia.com",
                "avatar" => "/assets/img/artist_" . (rand(0, 100) % 10 + 1) . ".png",
                "password" => password_hash("toto", PASSWORD_BCRYPT),
                "inscription_date" => $time,
                "modification_date" => $time,
            ];
        }
        $this->table()->insert($data)->save();
    }
}