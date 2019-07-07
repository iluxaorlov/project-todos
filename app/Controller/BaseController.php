<?php

namespace App\Controller;

use PDO;
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

    /**
     * @param string $id
     * @return array|null
     */
    protected function findOneById(string $id): ?array
    {
        // creating an sql query
        $query = 'SELECT * FROM task WHERE id = :id;';

        // returning object
        return $this->query($query, ['id' => $id])[0];
    }

    protected function findByToken(string $token)
    {
        // creating an sql query
        $query = 'SELECT * FROM task WHERE token = :token;';

        // returning object
        return $this->query($query, ['token' => $token]);
    }

    /**
     * @param string $query
     * @param array $params
     * @return array|null
     */
    protected function query(string $query, array $params = []): ?array
    {
        $statement = $this->database->prepare($query);
        $statement->execute($params);

        if ($statement) {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        return null;
    }
}
