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
                ->select('submission_answers.*, questions.name as question_name, answers.label as answer_text')
                ->join('questions', 'questions.id = submission_answers.question_id')
                ->join('answers', 'answers.id = submission_answers.answer_id')
                ->where('submission_answers.submission_id', $submission['id'])
                ->findAll();
        }

        return $submissions;
    }

    public function getSubmissionAnswers(int $submissionId)
    {
        return $this->submissionAnswerModel->getAnswersBySubmissionId($submissionId);
    }

    public function exportSubmissionsToCSV($questionnaireId)
    {
        $submissions = $this->getSubmissionsByQuestionnaireId($questionnaireId);

        if (empty($submissions)) {
            return redirect()->back()->with('error', 'No submissions found.');
        }

        $filename = 'questionnaire_'.$questionnaireId.'_submissions.csv';

        $output = fopen('php://temp', 'w'); // Use temporary memory for CSV generation

        // Write CSV header
        fputcsv($output, ['Submission ID', 'Question ID', 'Question Name', 'Answer ID', 'Answer Text']);

        // Write submission data
        foreach ($submissions as $submission) {
            foreach ($submission['answers'] as $answer) {
                fputcsv($output, [
                    $submission['id'],
                    $answer['question_id'],
                    $answer['question_name'],
                    $answer['answer_id'],
                    $answer['answer_text'],
                ]);
            }
        }

        rewind($output);
        $csvData = stream_get_contents($output);
        fclose($output);

        return response()
            ->setHeader('Content-Type', 'text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="'.$filename.'"')
            ->setBody($csvData);
    }
}
