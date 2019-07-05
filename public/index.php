<?php

use Slim\App;
use Slim\Views\Twig;
use Slim\Http\Uri;
use Slim\Http\Environment;
use Slim\Views\TwigExtension;
use App\Controller\MainController;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

$container = $app->getContainer();

$container['view'] = function ($container) {
    $view = new Twig('path/to/templates', [
        'cache' => 'path/to/cache'
    ]);

    $router = $container->get('router');
    $uri = Uri::createFromEnvironment(new Environment($_SERVER));
    $view->addExtension(new TwigExtension($router, $uri));

    return $view;
};

$app->get('/', MainController::class . ':index')->setName('index');

$app->run();