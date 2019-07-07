<?php

namespace App\Handler;

use App\Controller\BaseController;
use Slim\Http\Request;
use Slim\Http\Response;

class NotFoundHandler extends BaseController
{
    public function __invoke(Request $request, Response $response)
    {
        return $this->view->render($response, 'error/404.twig')
            ->withStatus(404);
    }
}
