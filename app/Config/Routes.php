<?php

use CodeIgniter\Router\RouteCollection;

/*
 * @var RouteCollection $routes
 */
$routes->get('questionnaires', 'QuestionnaireController::index');
$routes->addRedirect('/', 'questionnaires');
$routes->get('questionnaires/create', 'QuestionnaireController::create');
$routes->get('questionnaires/edit/(:num)', 'QuestionnaireController::edit/$1');
$routes->post('questionnaires/store', 'QuestionnaireController::store');
$routes->post('questionnaires/delete/(:num)', 'QuestionnaireController::delete/$1');
