<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TienTe extends Migration
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
            'muatienmat' => [
                'type' => 'DECIMAL', // Thay đổi kiểu dữ liệu thành DECIMAL
                'constraint' => '10,4', // Đặt ràng buộc DECIMAL(10, 4)
                'null' => FALSE,
            ],
            'muachuyenkhoan' => [
                'type' => 'DECIMAL', // Thay đổi kiểu dữ liệu thành DECIMAL
                'constraint' => '10,4', // Đặt ràng buộc DECIMAL(10, 4)
                'null' => FALSE,
            ],
            'banra' => [
                'type' => 'DECIMAL', // Thay đổi kiểu dữ liệu thành DECIMAL
                'constraint' => '10,4', // Đặt ràng buộc DECIMAL(10, 4)
                'null' => FALSE,
            ],

            'thoigiancapnhat DATETIME NOT NULL DEFAULT current_timestamp',

        ]);
        $this->forge->addPrimaryKey('id');
        $attributes = [
            'ENGINE' => 'InnoDB',
            'CHARACTER SET' => 'utf8',
            'COLLATE' => 'utf8_general_ci'
        ];
        $this->forge->createTable('tiente', TRUE, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('tiente', TRUE);
    }
}
