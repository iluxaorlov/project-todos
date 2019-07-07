<?php

namespace App\Controller;

use Psr\Container\ContainerInterface;

abstract class BaseController
{
    protected $view;
    protected $database;
    protected $settings;

    public function __construct(ContainerInterface $container)
    {
        $this->view = $container->get('view');
        $this->database = $container->get('database');
        $this->settings = $container->get('settings');
    }
}
