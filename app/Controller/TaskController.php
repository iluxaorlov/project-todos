<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class TaskController extends BaseController
{
    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function create(Request $request, Response $response): Response
    {
        $text = trim($request->getParam('text'));

        if ($text === '') {
            return $response->withStatus(400);
        }

        $query = 'INSERT INTO task (text, session) VALUES (:text, :session);';
        $session = session_id();
        $this->query($query, ['text' => $text, 'session' => $session]);

        $lastId = $this->database->lastInsertId();
        $task = $this->findOneById($lastId);

        if ($task === null) {
            return $response->withStatus(404);
        }

        return $response->withJson($task)->withStatus(200);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function read(Request $request, Response $response, array $args): Response
    {
        $id = trim($args['id']);

        if ($id === '') {
            return $response->withStatus(400);
        }

        $task = $this->findOneById($id);

        if ($task === null) {
            return $response->withStatus(404);
        }

        return $response->withJson($task)->withStatus(200);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function update(Request $request, Response $response, array $args): Response
    {
        $id = trim($args['id']);

        if ($id === '') {
            return $response->withStatus(400);
        }

        $parameters = $request->getParams();

        foreach ($parameters as $column => $parameter) {
            $parameter = trim($parameter);

            if ($parameter === '') {
                return $response->withStatus(400);
            }

            $parameters[$column] = $parameter;
        }

        $parametersArray = array_map(function($column) {
            return $column . ' = :' . $column;
        }, array_keys($parameters));

        $parameters['id'] = $id;
        $query = 'UPDATE task SET ' . implode(', ', $parametersArray) . ' WHERE id = :id;';
        $this->query($query, $parameters);
        $task = $this->findOneById($id);

        if ($task === null) {
            return $response->withStatus(404);
        }

        return $response->withJson($task)->withStatus(200);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function delete(Request $request, Response $response, array $args): Response
    {
        $id = trim($args['id']);

        if ($id === '') {
            return $response->withStatus(400);
        }

        $task = $this->findOneById($id);

        if ($task === null) {
            return $response->withStatus(404);
        }

        $query = 'DELETE FROM task WHERE id = :id;';
        $this->query($query, ['id' => $id]);

        return $response->withStatus(200);
    }
}
