<?php

namespace App\Controllers;

class SubmissionController extends BaseController
{
    protected $submissionService;
    protected $questionService;

    public function __construct()
    {
        $this->submissionService = service('submissionService');
        $this->questionService = service('questionService');
    }

    public function create($questionnaireId)
    {
        $questions = $this->questionService->getQuestionsByQuestionnaireId($questionnaireId);

        return view('submissions/create', ['questions' => $questions, 'questionnaireId' => $questionnaireId]);
    }
}
