<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class Fakultas extends Seeder
{
    public function run()
    {
        $fakultas = ['FMIPA', 'FT', 'FP', 'FH', 'FISIP', 'FKIP', 'FEB', 'FK'];
        for ($i = 1; $i <= 8; $i++) {
            $data = [
                'id_fakultas' => $i,
                'nama_fakultas' => $fakultas[$i - 1],
                'created_at' => Time::now(),
            ];
            $this->db->table('fakultas')->insert($data);
        }
    }
}
