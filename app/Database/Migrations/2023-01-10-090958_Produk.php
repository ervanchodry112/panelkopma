<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Produk extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_produk' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'nama_produk' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'harga_produk' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'gambar_produk' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id_produk');
        $this->forge->createTable('produk');

        // Create Tabel laporan_keuangan
        $this->forge->addField([
            'id'        => [
                'type'  => 'INT',
                'constraint'    => 3,
            ],
            'judul'     =>
            [
                'type'  => 'VARCHAR',
                'constraint'    => 255,
            ],
            'bulan'     =>
            [
                'type'  => 'INT',
                'constraint'    => 2,
            ],
            'tahun'     =>
            [
                'type'  => 'YEAR',
            ],
            'created_at'    => [
                'type'  => 'DATETIME',
                'null'  => true,
            ],
            'updated_at'    =>
            [
                'type'  => 'DATETIME',
                'null'  => true,
            ],
            'deleted_at'    =>
            [
                'type'  => 'DATETIME',
                'null'  => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('laporan_keuangan');
    }

    public function down()
    {
        $this->forge->dropTable('laporan_keuangan');
        $this->forge->dropTable('produk');
    }
}
