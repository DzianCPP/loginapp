<?php

namespace core\models;

use PDO;
use core\application\Database;

class Users
{
    private PDO $conn;
    private Database $database;
    private Validator $validator;
    private SqlPreparer $sqlPreparer;
    private array $sqlQueries;

    public function __construct()
    {
        $this->database = new Database();
        $this->validator = new Validator();
        $this->sqlPreparer = new SqlPreparer();
        $this->sqlQueries = require "sqlQueries.php";
        $this->conn = $this->database->getConnection();
    }

    public function insertNewUser(): bool
    {
        $params = array (
            'email' => $this->validator->makeDataSafe($_POST['email']),
            'fullName' => $this->validator->makeDataSafe($_POST['name']),
            'gender' => $this->validator->makeDataSafe($_POST['gender']),
            'status' => $this->validator->makeDataSafe($_POST['status'])
        );

        if (!$this->validator->userDataValid($params['email'], $params['fullName'])) {
            return false;
        }

        $query = $this->sqlPreparer->prepareInsertSql($params, $this->conn);
        if (!$query->execute()) {
            return false;
        }
        return true;
    }

    public function seedData(array $data): bool
    {
        $params = array (
            'email' => $data['email'],
            'fullName' => $data['fullName'],
            'gender' => $data['gender'],
            'status' => $data['status']
        );

        $query = $this->sqlPreparer->prepareInsertSql($params, $this->conn);
        if (!$query->execute()) {
            return false;
        }

        return true;
    }

    public function tableEmpty(): bool
    {
        $query = $this->sqlPreparer->prepareCheckIfTableEmptySql($this->conn);
        $query->execute();
        $result = $query->setFetchMode(PDO::FETCH_ASSOC);
        $result = $query->fetchAll();
        if ($result[0]['COUNT(*)'] !== 0) {
            return false;
        }
        return true;
    }

    public function checkIfUserExists(): bool
    {
        return true;
    }
}