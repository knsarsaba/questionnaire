<?php

namespace App\Services\Contracts;

interface QuestionnaireServiceInterface
{
    public function getQuestionnaireById(int $id);

    public function getAllQuestionnaires(): array;

    public function createQuestionnaire(string $name);

    public function updateQuestionnaire(int $id, string $name);

    public function deleteQuestionnaire(int $id);
}
