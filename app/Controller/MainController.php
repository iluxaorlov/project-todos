<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class MainController extends BaseController
{
    public function index(Request $request, Response $response)
    {
        $tasks = $this->findAllBySession(session_id());

        return $this->view->render($response, 'index/index.twig', [
            'tasks' => $tasks
        ]);
    }
}
