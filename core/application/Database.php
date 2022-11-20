<?php

namespace core\application;
use PDO;
use Dotenv\Dotenv;

class Database
{
    private PDO $connection;
    private array $env = [];

    public function __construct()
    {
        $this->env = $this->getDotEnv();
        $dbHostName = $this->env['DB_HOST_NAME'];
        $dbPassword = $this->env['DB_PASSWORD'];
        $dbUserName = $this->env['DB_USER_NAME'];
        $dbName = $this->env['DB_NAME'];
        $dsn = "mysql:host=".$dbHostName.";dbname=".$dbName;

        $this->connection = new PDO($dsn, $dbUserName, $dbPassword);
    }

    public function &getConnection(): PDO
    {
        return $this->connection;
    }

    private function getDotEnv(): array
    {
        $dotenv = Dotenv::createImmutable(BASE_PATH);
        $dotenv->safeLoad();
        return $_ENV;
    }
}