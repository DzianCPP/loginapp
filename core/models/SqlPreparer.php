<?php

namespace core\models;
use PDO;

class SqlPreparer
{
    private array $sqlQueries;

    public function __construct()
    {
        $this->sqlQueries = require "sqlQueries.php";
    }

    public function prepareInsertSql(array $params, $conn): bool|\PDOStatement
    {
        $sqlQuery = $this->sqlQueries["insertUser"];
        $query = $conn->prepare($sqlQuery);
        $query->bindParam(':email', $params['email']);
        $query->bindParam(':fullName', $params['fullName']);
        $query->bindParam(':gender', $params['gender']);
        $query->bindParam(':status', $params['status']);
        return $query;
    }

    public function prepareSelectAllSql($conn): bool|\PDOStatement
    {
        $sqlQuery = $this->sqlQueries["selectAll"];
        return $conn->prepare($sqlQuery);
    }

    public function prepareSelectById(int $id, $conn): bool|\PDOStatement
    {
        $sqlQuery = $this->sqlQueries["selectById"];
        $query = $conn->prepare($sqlQuery);
        $query->bindParam(1, $id, PDO::PARAM_INT);
        return $query;
    }

    public function prepareUpdateSql(array $params, $conn): bool|\PDOStatement
    {
        $sqlQuery = $this->sqlQueries["update"];
        $query = $conn->prepare($sqlQuery);
        $query->bindParam(':newEmail', $params['newEmail']);
        $query->bindParam(':newFullName', $params['newFullName']);
        $query->bindParam(':newGender', $params['newGender']);
        $query->bindParam(':newStatus', $params['newStatus']);
        $query->bindParam(':userID', $params['userID']);
        return $query;
    }

    public function prepareDeleteSql(int $id, $conn): bool|\PDOStatement
    {
        $sqlQuery = $this->sqlQueries["delete"];
        $query = $conn->prepare($sqlQuery);
        $query->bindParam(":id", $id);
        return $query;
    }

    public function prepareCheckIfTableEmptySql($conn): bool |\PDOStatement
    {
        $sqlQuery = $this->sqlQueries["checkEmpty"];
        $query = $conn->prepare($sqlQuery);
        return $query;
    }
}