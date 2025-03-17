<?php

namespace App\Services\Contracts;

interface QuestionServiceInterface
{
    public function getQuestionById(int $id);

    public function getQuestionsByQuestionnaireId(int $questionnaireId): array;

    public function addQuestion(int $questionnaireId, string $name);

    public function deleteQuestion(int $id);
}
