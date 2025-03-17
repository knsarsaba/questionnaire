<?php

namespace App\Controllers;

use App\Services\Contracts\QuestionServiceInterface;

class QuestionController extends BaseController
{
    protected QuestionServiceInterface $questionService;

    public function __construct()
    {
        $this->questionService = service('questionService');
    }

    public function store()
    {
        $questionnaireId = $this->request->getPost('questionnaire_id');
        $name = $this->request->getPost('name');

        $this->questionService->addQuestion($questionnaireId, $name);

        return redirect()->to('questionnaires/'.$questionnaireId);
    }

    public function delete($id)
    {
        $this->questionService->deleteQuestion($id);

        return redirect()->back();
    }
}
