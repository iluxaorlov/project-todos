<?php

use Slim\App;
use App\Controller\MainController;
use App\Controller\TaskController;

$app->get('/', MainController::class . ':index')->setName('index');

$app->group('/api', function (App $app) {
    $app->post('', TaskController::class . ':create');
    $app->get('/{id}', TaskController::class . ':read');
    $app->put('/{id}', TaskController::class . ':update');
    $app->delete('/{id}', TaskController::class . ':delete');
});