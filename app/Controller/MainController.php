<?php

namespace App\Controller;

class MainController extends AbstractController
{
    public function index($request, $response)
    {
        return $this->container->view->render($response, 'index/index.twig');
    }
}
