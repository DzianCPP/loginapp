<?php

namespace core\controllers;
use core\models\Users;
use function MongoDB\BSON\fromJSON;

class UserController
{
    public function create(): void
    {
        $users = new Users();
        if ($users->insertNewUser()) {
            $this->show();
        } else {
            $email = $_POST['email'];
            $fullName = $_POST['name'];
            $this->new($email, $fullName);
        }
    }

    public function new(string $email = '', string $fullName = ''): void
    {
        include VIEW_PATH . "/forms/newUser.html";
    }

    public function show(): void
    {
        $users = new Users();
        $allUsers = $users->getAllUsers();
        $this->renderAllUsers($allUsers);
    }

    public function showById(): void
    {
        $users = new Users();
        $userID = $_GET['userID'];
        $userID = ltrim(rtrim($userID, '}'), '{');
        $user = $users->getUserById($userID);
        $this->renderOneUser($user);
    }

    public function editUser(): void
    {
        $users = new Users();
        $userID = $_GET['userID'];
        $userID = rtrim($userID, '}');
        $userID = ltrim($userID, '{');
        $userToEdit = $users->getUserById($userID);
        $currentEmail = $userToEdit['email'];
        $currentFullName = $userToEdit['fullName'];
        $currentGender = $userToEdit['gender'];
        $currentStatus = $userToEdit['status'];
        include VIEW_PATH . "/forms/editUser.html";
    }

    public function update(): void
    {
        $jsonString = file_get_contents("php://input");
        $newUserInfo = json_decode($jsonString, true);
        $users = new Users();
        if ($users->editUser($newUserInfo)) {
            http_response_code(200);
            $this->show();
        }
    }

    public function delete(): void
    {
        $jsonString = file_get_contents("php://input");
        $id = json_decode($jsonString, true);
        $id = $id['userID'];
        $id = ltrim($id, "\"");
        $id = rtrim($id, "\"");
        $users = new Users();
        if ($users->delete($id)) {
            http_response_code(200);
        }
    }

    private function renderAllUsers(array $allUsers): void
    {
        include VIEW_PATH . "tables/users.html";
    }

    private function renderOneUser(array $user): void
    {
        include VIEW_PATH . "tables/one.html";
    }
}