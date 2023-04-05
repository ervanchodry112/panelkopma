<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableAlumni extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_alumni' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'nama_alumni' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'email_alumni' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'no_hp_alumni' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'alamat_alumni' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'status_alumni' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
            'tahun_lulus' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'slug_alumni' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
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
        $this->forge->addPrimaryKey('id_alumni', true);
        $this->forge->createTable('alumni');
    }

    public function down()
    {
        $this->forge->dropTable('alumni');
    }
}
