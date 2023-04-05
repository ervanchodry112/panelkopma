<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnTagihan extends Migration
{
    public function up()
    {
        // Add Column tagihan to table simpanan
        $fields = [
            'tagihan' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
        ];
        $this->forge->addColumn('data_simpanan', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('data_simpanan', 'tagihan');
    }
}
