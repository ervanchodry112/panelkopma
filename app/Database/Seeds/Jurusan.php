<?php

namespace App\Database\Seeds;

use CodeIgniter\I18n\Time;
use CodeIgniter\Database\Seeder;

class Jurusan extends Seeder
{
    public function run()
    {
        $fake = \Faker\Factory::create('id_ID');
        for ($i = 1; $i <= 10; $i++) {
            $jurusan = [
                'id_jurusan' => $i,
                'nama_jurusan' => $fake->unique()->jobTitle,
                'id_fakultas' => $fake->numberBetween(1, 8),
                'created_at' => Time::now(),
            ];
            $this->db->table('jurusan')->insert($jurusan);
        }
    }
}
