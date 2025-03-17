<?php

namespace App\Services;

use App\Models\QuestionModel;

class QuestionService
{
    protected $questionModel;

    public function __construct()
    {
        $this->questionModel = model(QuestionModel::class);
    }

    public function addQuestion(int $questionnaireId, string $name)
    {
        return $this->questionModel->insert([
            'questionnaire_id' => $questionnaireId,
            'name' => $name,
        ]);
    }

    public function getQuestionsByQuestionnaireId(int $questionnaireId)
    {
        return $this->questionModel->where('questionnaire_id', $questionnaireId)->findAll();
    }
}
