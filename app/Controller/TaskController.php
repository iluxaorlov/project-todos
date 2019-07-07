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
            $query = 'INSERT INTO task (text) VALUES (:text);';
            // executing query
            $this->query($query, ['text' => $text]);
            // getting last id
            $lastInsertId = $this->database->lastInsertId();
            // finding task
            $task = $this->getTaskById($lastInsertId);

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
            $task = $this->getTaskById($id);

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
            $task = $this->getTaskById($id);

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
            $task = $this->getTaskById($id);

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

    /**
     * @param string $id
     * @return array|null
     */
    private function getTaskById(string $id): ?array
    {
        // creating an sql query
        $query = 'SELECT * FROM task WHERE id = :id;';

        // returning object
        return $this->query($query, ['id' => $id]);
    }

    /**
     * @param string $query
     * @param array $params
     * @return array|null
     */
    private function query(string $query, array $params = []): ?array
    {
        $statement = $this->database->prepare($query);
        $statement->execute($params);

        if ($statement) {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        return null;
    }
}
