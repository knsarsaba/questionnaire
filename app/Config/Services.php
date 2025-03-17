<?php

namespace Config;

use App\Models\AnswerModel;
use App\Services\AnswerService;
use App\Services\QuestionnaireService;
use App\Services\QuestionService;
use App\Services\SubmissionService;
use CodeIgniter\Config\BaseService;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    /*
     * public static function example($getShared = true)
     * {
     *     if ($getShared) {
     *         return static::getSharedInstance('example');
     *     }
     *
     *     return new \CodeIgniter\Example();
     * }
     */

    public static function questionnaireService($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('questionnaireService');
        }

        return new QuestionnaireService();
    }

    public static function questionService($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('questionService');
        }

        return new QuestionService();
    }

    public static function answerService($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('answerService');
        }

        return new AnswerService(model(AnswerModel::class));
    }

    public static function submissionService($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('submissionService');
        }

        return new SubmissionService();
    }
}
