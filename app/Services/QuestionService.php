<?php

namespace App\Services;

use App\Models\AnswerModel;
use App\Models\QuestionModel;

class QuestionService
{
    protected $questionModel;
    protected $answerModel;

    public function __construct()
    {
        $this->questionModel = model(QuestionModel::class);
        $this->answerModel = model(AnswerModel::class);
    }

    public function addQuestion(int $questionnaireId, string $name)
    {
        return $this->questionModel->insert([
            'questionnaire_id' => $questionnaireId,
            'name' => $name,
        ]);
    }

    public function deleteQuestion(int $id)
    {
        return $this->questionModel->delete($id);
    }

    public function getQuestionsByQuestionnaireId($questionnaireId)
    {
        $questions = $this->questionModel->where('questionnaire_id', $questionnaireId)->findAll();

        foreach ($questions as &$question) {
            $question['answers'] = $this->answerModel->where('question_id', $question['id'])->findAll();
        }

        return $questions;
    }
}
