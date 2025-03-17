<?php

namespace App\Services;

use App\Models\AnswerModel;
use App\Services\Contracts\AnswerServiceInterface;

class AnswerService implements AnswerServiceInterface
{
    protected AnswerModel $answerModel;

    public function __construct(AnswerModel $answerModel)
    {
        $this->answerModel = $answerModel;
    }

    public function getAnswersByQuestionId(int $questionId): array
    {
        return $this->answerModel->where('question_id', $questionId)->findAll();
    }

    public function addAnswer(int $questionId, string $label)
    {
        return $this->answerModel->insert([
            'question_id' => $questionId,
            'label' => $label,
        ]);
    }

    public function deleteAnswer(int $id)
    {
        return $this->answerModel->delete($id);
    }
}
