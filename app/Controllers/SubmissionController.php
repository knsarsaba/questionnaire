<?php

namespace App\Controllers;

class SubmissionController extends BaseController
{
    protected $submissionService;
    protected $questionService;
    protected $questionnaireService;

    public function __construct()
    {
        $this->submissionService = service('submissionService');
        $this->questionService = service('questionService');
        $this->questionnaireService = service('questionnaireService');
    }

    public function index()
    {
        $questionnaireId = $this->request->getGet('questionnaire_id');
        if (!$questionnaireId) {
            return redirect()->to('/questionnaires')->with('error', 'No questionnaire selected.');
        }

        $questionnaire = $this->questionnaireService->getQuestionnaireById($questionnaireId);
        if (!$questionnaire) {
            return redirect()->to('/questionnaires')->with('error', 'Questionnaire not found.');
        }

        return view('submissions/index', [
            'questionnaire' => $questionnaire,
            'submissions' => $this->submissionService->getSubmissionsByQuestionnaireId($questionnaireId),
        ]);
    }

    public function create($questionnaireId)
    {
        $questions = $this->questionService->getQuestionsByQuestionnaireId($questionnaireId);

        return view('submissions/create', ['questions' => $questions, 'questionnaireId' => $questionnaireId]);
    }

    public function store()
    {
        $questionnaireId = $this->request->getPost('questionnaire_id');
        $answers = $this->request->getPost('answers');

        if (!$answers) {
            return redirect()->to('submissions/create/'.$questionnaireId)->with('error', 'Please answer all questions.');
        }

        $submissionId = $this->submissionService->submitQuestionnaire($questionnaireId, $answers);

        return redirect()->to('questionnaires')->with('success', 'Submission successful!');
    }

    public function show($submissionId)
    {
        $submission = $this->submissionService->getSubmissionById($submissionId);
        if (!$submission) {
            return redirect()->to('/submissions')->with('error', 'Submission not found.');
        }

        $questionnaire = $this->questionnaireService->getQuestionnaireById($submission['questionnaire_id']);

        return view('submissions/show', [
            'submission' => $submission,
            'questionnaire' => $questionnaire,
            'answers' => $this->submissionService->getSubmissionAnswers($submissionId),
        ]);
    }

    public function export($questionnaireId)
    {
        return $this->submissionService->exportSubmissionsToCSV($questionnaireId);
    }

    public function import()
    {
        $file = $this->request->getFile('csv_file');

        if (!$file->isValid() || $file->getExtension() !== 'csv') {
            return redirect()->back()->with('error', 'Invalid file. Please upload a CSV file.');
        }

        $importResult = $this->submissionService->importSubmissionsFromCSV($file);

        if ($importResult['status'] === 'error') {
            return redirect()->back()->with('error', $importResult['message']);
        }

        return redirect()->to('/questionnaires')->with('success', 'Submissions imported successfully.');
    }
}
