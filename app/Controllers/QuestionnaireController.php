<?php

namespace App\Controllers;

class QuestionnaireController extends BaseController
{
    protected $questionnaireService;
    protected $questionService;

    public function __construct()
    {
        $this->questionnaireService = service('questionnaireService');
        $this->questionService = service('questionService');
    }

    public function index()
    {
        $questionnaires = $this->questionnaireService->getAllQuestionnaires();

        return view('questionnaires/index', ['questionnaires' => $questionnaires]);
    }

    public function view($id)
    {
        $questionnaire = $this->questionnaireService->getQuestionnaireById($id);
        if (!$questionnaire) {
            return redirect()->to('questionnaires')->with('error', 'Questionnaire not found');
        }

        return view('questionnaires/view', [
            'questionnaire' => $questionnaire,
            'questions' => $this->questionService->getQuestionsByQuestionnaireId($id),
        ]);
    }

    public function create()
    {
        return view('questionnaires/create');
    }

    public function edit($id)
    {
        $questionnaire = $this->questionnaireService->getQuestionnaireById($id);

        if (!$questionnaire) {
            return redirect()->to('questionnaires')->with('error', 'Questionnaire not found');
        }

        return view('questionnaires/create', ['questionnaire' => $questionnaire]);
    }

    public function store()
    {
        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');

        if (empty($name)) {
            return redirect()->back()->with('errors', ['Name is required'])->withInput();
        }

        if ($id) {
            $this->questionnaireService->updateQuestionnaire($id, $name);

            return redirect()->to('questionnaires')->with('success', 'Questionnaire updated successfully');
        } else {
            $newId = $this->questionnaireService->createQuestionnaire($name);

            return redirect()->to('questionnaires')->with('success', 'Questionnaire created successfully');
        }
    }

    public function delete($id)
    {
        if ($this->questionnaireService->deleteQuestionnaire($id)) {
            return redirect()->to('questionnaires')->with('success', 'Questionnaire deleted successfully');
        } else {
            return redirect()->to('questionnaires')->with('error', 'Failed to delete questionnaire');
        }
    }
}
