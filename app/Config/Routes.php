<?php

use CodeIgniter\Router\RouteCollection;

/*
 * @var RouteCollection $routes
 */
$routes->addRedirect('/', 'questionnaires');
$routes->get('questionnaires', 'QuestionnaireController::index');
$routes->get('questionnaires/(:num)', 'QuestionnaireController::view/$1');
$routes->get('questionnaires/create', 'QuestionnaireController::create');
$routes->get('questionnaires/edit/(:num)', 'QuestionnaireController::edit/$1');
$routes->post('questionnaires/delete/(:num)', 'QuestionnaireController::delete/$1');
$routes->post('questionnaires/store', 'QuestionnaireController::store');
$routes->get('questionnaires/export/(:num)', 'SubmissionController::export/$1');

$routes->post('questions/store', 'QuestionController::store');
$routes->post('questions/delete/(:num)', 'QuestionController::delete/$1');

$routes->post('answers/store', 'AnswerController::store');
$routes->post('answers/delete/(:num)', 'AnswerController::delete/$1');

$routes->get('submissions', 'SubmissionController::index');
$routes->get('submissions/(:num)', 'SubmissionController::show/$1');
$routes->get('submissions/create/(:num)', 'SubmissionController::create/$1');
$routes->post('submissions/store', 'SubmissionController::store');
