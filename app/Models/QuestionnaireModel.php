<?php

namespace App\Models;

use CodeIgniter\Model;

class QuestionnaireModel extends Model
{
    protected $table = 'questionnaires';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['name'];
}
