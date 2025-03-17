<?php

namespace App\Controllers;

class AnswerController extends BaseController
{
    protected $answerService;

    public function __construct()
    {
        $this->answerService = service('answerService');
    }

    public function store()
    {
        $questionnaireId = $this->request->getPost('questionnaire_id');
        $questionId = $this->request->getPost('question_id');
        $label = $this->request->getPost('label');

        $this->answerService->addAnswer($questionId, $label);

        return redirect()->to('questionnaires/'.$questionnaireId);
    }

    public function delete($id)
    {
        $questionnaireId = $this->request->getPost('questionnaire_id');

        $this->answerService->deleteAnswer($id);

        return redirect()->to('questionnaires/'.$questionnaireId);
    }
}
