<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LoaiTienTe extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
                'auto_increment' => TRUE,
            ],
            'mangoaite' => [
                'type' => 'VARCHAR',
                'constraint' => 11,
                'null' => FALSE,

            ],
            'tenngoaite' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $attributes = [
            'ENGINE' => 'InnoDB',
            'CHARACTER SET' => 'utf8',
            'COLLATE' => 'utf8_general_ci'
        ];
        $this->forge->createTable('loaitiente', TRUE, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('loaitiente', TRUE);
    }
}
