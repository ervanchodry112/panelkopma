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

        // Create tabel program_kerja
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 4,
                'auto_increment' => true,
            ],
            'nama_program' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'rencana_pelaksanaan' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'user' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'tahun' => [
                'type' => 'YEAR',
                'constraint' => 4,
            ],
            'proposal' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'lpj' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'status' => [
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
        $this->forge->addForeignKey('user', 'users', 'username', 'CASCADE', 'CASCADE');
        $this->forge->createTable('program_kerja');
    }

    public function down()
    {
        $this->forge->dropTable('program_kerja');
        $this->forge->dropTable('survey_berjalan');
    }
}
