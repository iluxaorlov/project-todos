<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use PDO;

class MainController extends BaseController
{
    public function index(Request $request, Response $response)
    {
        $statement = $this->database->prepare('SELECT * FROM task;');
        $statement->execute();
        $tasks = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $this->view->render($response, 'index/index.twig', [
            'tasks' => $tasks
        ]);
    }
}
