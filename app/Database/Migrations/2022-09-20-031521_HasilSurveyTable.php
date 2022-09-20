<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HasilSurveyTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_laporan' => [
                'type'          => 'VARCHAR',
                'constraint'    => '20',
            ],
            'nama_survey' => [
                'type'          => 'VARCHAR',
                'constraint'    => '255',
            ],
            'deskripsi' => [
                'type'          => 'TEXT',
                'null'          => true,
            ],
            'tanggal_mulai' => [
                'type'          => 'DATE',
            ],
            'tanggal_selesai' => [
                'type'          => 'DATE',
            ],
            'file' => [
                'type'          => 'VARCHAR',
                'constraint'    => '255',
            ],
            'jumlah_responden' => [
                'type'          => 'INT',
                'constraint'    => '4',
            ],
            'created_at' => [
                'type'          => 'DATETIME',
                'null'          => true,
            ],
            'updated_at' => [
                'type'          => 'DATETIME',
                'null'          => true,
            ],
            'deleted_at' => [
                'type'          => 'DATETIME',
                'null'          => true,
            ],
        ]);
        $this->forge->addKey('id_laporan', true);
        $this->forge->createTable('hasil_survey');
    }

    public function down()
    {
        $this->forge->dropTable('hasil_survey');
    }
}
