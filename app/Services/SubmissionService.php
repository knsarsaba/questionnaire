<?php

namespace App\Services;

use App\Models\SubmissionAnswerModel;
use App\Models\SubmissionModel;

class SubmissionService
{
    protected $submissionModel;
    protected $submissionAnswerModel;

    public function __construct()
    {
        $this->submissionModel = model(SubmissionModel::class);
        $this->submissionAnswerModel = model(SubmissionAnswerModel::class);
    }

    public function submitQuestionnaire(int $questionnaireId, array $answers)
    {
        $submissionId = $this->submissionModel->insert([
            'questionnaire_id' => $questionnaireId,
            'submitted_at' => date('Y-m-d H:i:s'),
        ], true);

        foreach ($answers as $questionId => $answerId) {
            $this->submissionAnswerModel->insert([
                'submission_id' => $submissionId,
                'question_id' => $questionId,
                'answer_id' => $answerId,
            ]);
        }

        return $submissionId;
    }

    public function getSubmissionsByQuestionnaireId(int $questionnaireId)
    {
        $submissions = $this->submissionModel->where('questionnaire_id', $questionnaireId)->findAll();

        foreach ($submissions as &$submission) {
            $submission['answers'] = $this->submissionAnswerModel
                ->where('submission_id', $submission['id'])
                ->findAll();
        }

        return $submissions;
    }
}
