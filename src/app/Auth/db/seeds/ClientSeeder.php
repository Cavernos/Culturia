<?php

namespace G1c\Culturia\app\Auth\db\seeds;

use DateTime;
use G1c\Culturia\framework\Database\Migrator\Seeder;

class ClientSeeder extends Seeder
{
    protected $tableName = 'clients';

    public function run() {
        $data = [];
        $time = (new DateTime())->setTimestamp(rand(0, time()))->format('Y-m-d');
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                "username" => "User ". $i + 1,
                "avatar" => "/assets/img/oeuvre_". (rand(0, 100) % 4 + 1).".png",
                "inscription_date" => $time,
                "modification_date" => $time,
                "email" => "toto.". $i + 1 ."@gmail.com",
                "password" => password_hash("toto", PASSWORD_BCRYPT),
            ];
        }
        $this->table()->insert($data)->save();

    }
}