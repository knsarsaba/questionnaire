<?php

namespace App\Services;

use App\Models\AnswerModel;

class AnswerService
{
    protected $answerModel;

    public function __construct()
    {
        $this->answerModel = model(AnswerModel::class);
    }

    public function addAnswer(int $questionId, string $label)
    {
        return $this->answerModel->insert([
            'question_id' => $questionId,
            'label' => $label,
        ]);
    }

    public function getAnswersByQuestionId(int $questionId)
    {
        return $this->answerModel->where('question_id', $questionId)->findAll();
    }
}
