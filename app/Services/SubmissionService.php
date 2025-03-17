<?php

namespace App\Services;

use App\Models\SubmissionAnswerModel;
use App\Models\SubmissionModel;
use CodeIgniter\Database\Exceptions\DataException;

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
        $submissionData = ['questionnaire_id' => $questionnaireId];
        $this->submissionModel->insert($submissionData);
        $submissionId = $this->submissionModel->insertID();

        if (!$submissionId) {
            throw new DataException('Failed to create submission.');
        }

        $answerData = [];
        foreach ($answers as $questionId => $answerId) {
            $answerData[] = [
                'submission_id' => $submissionId,
                'question_id' => $questionId,
                'answer_id' => $answerId,
            ];
        }

        if (!empty($answerData)) {
            $this->submissionAnswerModel->insertBatch($answerData);
        }

        return $submissionId;
    }

    public function getSubmissionById(int $submissionId)
    {
        return $this->submissionModel->find($submissionId);
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

    public function getSubmissionAnswers(int $submissionId)
    {
        return $this->submissionAnswerModel->getAnswersBySubmissionId($submissionId);
    }
}
