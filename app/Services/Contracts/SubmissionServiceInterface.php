<?php

namespace App\Services\Contracts;

use CodeIgniter\HTTP\Files\UploadedFile;

interface SubmissionServiceInterface
{
    public function getSubmissionById(int $submissionId);

    public function getSubmissionsByQuestionnaireId(int $questionnaireId);

    public function getSubmissionAnswers(int $submissionId);

    public function submitQuestionnaire(int $questionnaireId, array $answers);

    public function exportSubmissionsToCSV(int $questionnaireId);

    public function importSubmissionsFromCSV(UploadedFile $file);
}
