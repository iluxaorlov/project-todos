<?php

namespace App\Controller;

abstract class AbstractController
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }
}