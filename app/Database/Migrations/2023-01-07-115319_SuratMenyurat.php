<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SuratMenyurat extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_surat' => [
                'type' => 'INT',
                'constraint' => 10,
                'auto_increment' => true,
            ],
            'no_surat' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'asal_surat' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'isi_surat' => [
                'type' => 'TEXT',
            ],
            'kode' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'tgl_surat' => [
                'type' => 'DATE',
            ],
            'tgl_diterima' => [
                'type' => 'DATE',
            ],
            'file' => [
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
        $this->forge->addPrimaryKey('id_surat');
        $this->forge->addUniqueKey('no_surat');
        $this->forge->createTable('surat_masuk');

        // create table digilib
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'judul' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'file' => [
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
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('digilib');
    }

    public function down()
    {
        $this->forge->dropTable('surat_masuk');
        $this->forge->dropTable('digilib');
    }
}
