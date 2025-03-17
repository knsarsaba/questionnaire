<?php

namespace App\Services;

use App\Models\AnswerModel;
use App\Models\QuestionModel;
use App\Services\Contracts\QuestionServiceInterface;

class QuestionService implements QuestionServiceInterface
{
    protected QuestionModel $questionModel;
    protected AnswerModel $answerModel;

    public function __construct(
        QuestionModel $questionModel,
        AnswerModel $answerModel
    ) {
        $this->questionModel = $questionModel;
        $this->answerModel = $answerModel;
    }

    public function getQuestionById(int $id)
    {
        return $this->questionModel->find($id);
    }

    public function getQuestionsByQuestionnaireId($questionnaireId): array
    {
        $questions = $this->questionModel->where('questionnaire_id', $questionnaireId)->findAll();

        foreach ($questions as &$question) {
            $question['answers'] = $this->answerModel->where('question_id', $question['id'])->findAll();
        }

        return $questions;
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
}
