<?php

namespace App\Services\Contracts;

interface AnswerServiceInterface
{
    public function getAnswersByQuestionId(int $questionId): array;

    public function addAnswer(int $questionId, string $label);

    public function deleteAnswer(int $id);
}
