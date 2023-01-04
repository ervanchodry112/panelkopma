<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class DataAnggota extends Seeder
{
    public function run()
    {
        $fake = \Faker\Factory::create('id_ID');

        for ($i = 0; $i < 10; $i++) {
            $nomor_anggota = $fake->unique()->numberBetween(1000, 9999) . "/Kopma_UL/22";
            $npm = $fake->unique()->numberBetween(2000000000, 2200000000);
            $name = $fake->name;
            $data_anggota = [
                'nomor_anggota' => $nomor_anggota,
                'nama_lengkap' => $name,
                'npm' => $npm,
                'email' => $fake->unique()->email,
                'nomor_hp' => $fake->unique()->phoneNumber,
                'tgl_diksar' => '2021-10-01',
                'id_jurusan' => $fake->numberBetween(1, 10),
                'created_at' => Time::now(),
            ];

            $this->db->table('data_anggota')->insert($data_anggota);

            $simpanan = [
                'nomor_anggota' => $nomor_anggota,
                'simpanan_wajib' => 0,
                'simpanan_pokok' => 0,
                'created_at' => Time::now(),
            ];

            $this->db->table('data_simpanan')->insert($simpanan);

            $poin = [
                'nomor_anggota' => $nomor_anggota,
                'poin' => 0,
                'created_at' => Time::now(),
            ];
            $this->db->table('data_poin')->insert($poin);

            $referal = [
                'nomor_anggota' => $nomor_anggota,
                'kode_referal' => strtoupper(substr($name, 0, 3) . substr($nomor_anggota, 0, 4)),
                'created_at' => Time::now(),
            ];

            $this->db->table('referal')->insert($referal);
        }
    }
}
