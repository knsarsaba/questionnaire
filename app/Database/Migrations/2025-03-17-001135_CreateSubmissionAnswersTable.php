<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubmissionAnswersTable extends Migration
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
            'submission_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'question_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'answer_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('submission_answers');
    }

    public function down()
    {
        $this->forge->dropTable('submission_answers');
    }
}
