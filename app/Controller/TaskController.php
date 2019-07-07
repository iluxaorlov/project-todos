<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use PDO;

class TaskController extends BaseController
{
    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function create(Request $request, Response $response): Response
    {
        // getting text
        $text = htmlentities($request->getParam('text'));

        if ($text) {
            // creating an sql query
            $query = 'INSERT INTO task (text, token) VALUES (:text, :token);';
            // executing query
            $this->query($query, [
                'text' => $text,
                'token' => session_id()
            ]);
            // getting last id
            $lastInsertId = $this->database->lastInsertId();
            // finding task
            $task = $this->findOneById($lastInsertId);

            if ($task) {
                // returning json with task
                return $response->withJson($task)->withStatus(201);
            }
        }

        // returning json with error
        return $response->withJson(['error' => 'Bad request'])->withStatus(400);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function read(Request $request, Response $response, array $args): Response
    {
        // getting id
        $id = htmlentities($args['id']);

        if ($id) {
            // finding task
            $task = $this->findOneById($id);

            if ($task) {
                // returning json with task
                return $response->withJson($task)->withStatus(200);
            }

            // returning json with error
            return $response->withJson(['error' => 'Not Found'])->withStatus(404);
        }

        // returning json with error
        return $response->withJson(['error' => 'Bad request'])->withStatus(400);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function update(Request $request, Response $response, array $args): Response
    {
        // getting id
        $id = htmlentities($args['id']);
        // getting all parameters
        $parameters = $request->getParams();

        if ($id && $parameters) {
            // mapping parameters for sql query
            $parametersArray = array_map(function($column) {
                return $column . ' = :' . $column;
            }, array_keys($parameters));
            // merging parameters and id for executing an sql query
            $parametersToValues = array_merge($parameters, ['id' => $id]);
            // creating an sql query
            $query = 'UPDATE task SET ' . implode(', ', $parametersArray) . ' WHERE id = :id;';
            // executing query
            $this->query($query, $parametersToValues);
            // finding task
            $task = $this->findOneById($id);

            if ($task) {
                // returning json with updated task
                return $response->withJson($task)->withStatus(200);
            }

            // returning json with error
            return $response->withJson(['error' => 'Not Found'])->withStatus(404);
        }

        // returning json with error
        return $response->withJson(['error' => 'Bad request'])->withStatus(400);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function delete(Request $request, Response $response, array $args): Response
    {
        // getting id
        $id = htmlentities($args['id']);

        if ($id) {
            // finding task
            $task = $this->findOneById($id);

            if ($task) {
                // creating an sql query
                $sql = 'DELETE FROM task WHERE id = :id;';
                // executing query
                $this->query($sql, ['id' => $id]);

                // returning json with message
                return $response->withStatus(204);
            }

            // returning json with error
            return $response->withJson(['error' => 'Not Found'])->withStatus(404);
        }

        // returning json with error
        return $response->withJson(['error' => 'Bad request'])->withStatus(400);
    }
}
