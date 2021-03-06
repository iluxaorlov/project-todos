<?php

use Slim\Http\Environment;
use Slim\Http\Uri;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use App\Handler\NotFoundHandler;

$container = $app->getContainer();

$container['view'] = function ($container) {
    $view = new Twig(__DIR__ . '/../templates', [
        'cache' => false
    ]);

    $router = $container->get('router');
    $uri = Uri::createFromEnvironment(new Environment($_SERVER));
    $view->addExtension(new TwigExtension($router, $uri));

    return $view;
};

$container['database'] = function ($container) {
    $settings = $container['settings']['database'];

    $pdo = new PDO('mysql:dbname=' . $settings['dbname'] . ';host=' . $settings['host'],
        $settings['user'],
        $settings['pass']
    );

    $pdo->exec('SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci');

    return $pdo;
};

$container['notFoundHandler'] = function ($container) {
    return new NotFoundHandler($container);
};
