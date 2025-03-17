<?php

namespace App\Models;

use CodeIgniter\Model;

class SubmissionAnswerModel extends Model
{
    protected $table = 'submissionanswers';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['submission_id', 'question_id', 'answer_id'];
}
