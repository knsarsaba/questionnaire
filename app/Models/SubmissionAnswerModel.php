<?php

namespace App\Models;

use CodeIgniter\Model;

class SubmissionAnswerModel extends Model
{
    protected $table = 'submission_answers';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['submission_id', 'question_id', 'answer_id'];

    public function getAnswersBySubmissionId(int $submissionId)
    {
        return $this->select('questions.name AS question_name, answers.label AS answer_text')
            ->join('questions', 'questions.id = submission_answers.question_id')
            ->join('answers', 'answers.id = submission_answers.answer_id')
            ->where('submission_answers.submission_id', $submissionId)
            ->findAll();
    }
}
