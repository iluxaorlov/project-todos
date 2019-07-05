<?php

namespace App\Controller;

use PDO;

class DatabaseController extends AbstractController
{
    private $pdo;
    private static $instance = null;

    public function __construct()
    {
        $settings = $this->container->get('settings');

        $this->pdo = new PDO('mysql:dbname=' . $settings['database']['dbname'] . ';host=' . $settings['database']['host'],
            $settings['database']['user'],
            $settings['database']['pass']
        );
    }

    /**
     * @return self
     */
    public function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param string $sql
     * @param array $params
     * @param string $class
     * @return array|null
     */
    public function query(string $sql, array $params, string $class): ?array
    {
        $prepare = $this->pdo->prepare($sql);
        $execute = $prepare->execute($params);

        if ($execute) {
            $result = $prepare->fetchAll(PDO::FETCH_CLASS, $class);

            if ($result) {
                return $result;
            }
        }

        return null;
    }
}