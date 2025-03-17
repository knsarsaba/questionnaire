<?php

namespace App\Services;

use App\Models\QuestionnaireModel;
use App\Services\Contracts\QuestionnaireServiceInterface;

class QuestionnaireService implements QuestionnaireServiceInterface
{
    protected QuestionnaireModel $questionnaireModel;

    public function __construct(QuestionnaireModel $questionnaireModel)
    {
        $this->questionnaireModel = $questionnaireModel;
    }

    public function getQuestionnaireById(int $id)
    {
        return $this->questionnaireModel->find($id);
    }

    public function getAllQuestionnaires(): array
    {
        return $this->questionnaireModel->findAll();
    }

    public function createQuestionnaire(string $name)
    {
        return $this->questionnaireModel->insert(['name' => $name]);
    }

    public function updateQuestionnaire(int $id, $name)
    {
        return $this->questionnaireModel->update($id, ['name' => $name]);
    }

    public function deleteQuestionnaire(int $id)
    {
        return $this->questionnaireModel->delete($id);
    }
}
