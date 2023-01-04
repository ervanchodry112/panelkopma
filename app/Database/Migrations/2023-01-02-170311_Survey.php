<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Survey extends Migration
{
    public function up()
    {
        // Create tabel survey_berjalan
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 4,
                'auto_increment' => true,
            ],
            'nama_survey' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'tgl_mulai' => [
                'type' => 'DATE',
            ],
            'tgl_selesai' => [
                'type' => 'DATE',
            ],
            'link' => [
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
        $this->forge->createTable('survey_berjalan');

    }

    public function down()
    {
        $this->forge->dropTable('survey_berjalan');
    }
}
