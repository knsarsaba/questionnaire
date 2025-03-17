<?php

namespace App\Services;

use App\Models\QuestionnaireModel;

class QuestionnaireService
{
    protected $questionnaireModel;

    public function __construct()
    {
        $this->questionnaireModel = model(QuestionnaireModel::class);
    }

    public function createQuestionnaire(string $name)
    {
        return $this->questionnaireModel->insert(['name' => $name]);
    }

    public function getAllQuestionnaires()
    {
        return $this->questionnaireModel->findAll();
    }
}
