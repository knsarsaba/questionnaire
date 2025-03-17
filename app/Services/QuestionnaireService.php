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

    public function getQuestionnaireById($id)
    {
        return $this->questionnaireModel->find($id);
    }

    public function getAllQuestionnaires()
    {
        return $this->questionnaireModel->findAll();
    }

    public function deleteQuestionnaire($id)
    {
        $questionnaireModel = model(QuestionnaireModel::class);

        return $questionnaireModel->delete($id);
    }

    public function createQuestionnaire(string $name)
    {
        return $this->questionnaireModel->insert(['name' => $name]);
    }

    public function updateQuestionnaire($id, $name)
    {
        return $this->questionnaireModel->update($id, ['name' => $name]);
    }
}
