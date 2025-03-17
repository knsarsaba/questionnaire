<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateQuestionnairesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('questionnaires');
    }

    public function down()
    {
        $this->forge->dropTable('questionnaires');
    }
}
