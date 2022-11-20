<?php

namespace core\controllers;
use core\models\Users;
use function MongoDB\BSON\fromJSON;

class UserController
{
    public function register(): void
    {
        $users = new Users();
        if ($users->insertNewUser()) {
            $this->login();
        } else {
            $email = $_POST['email'];
            $fullName = $_POST['name'];
            $this->new($email, $fullName);
        }
    }

    public function new(string $email = '', string $fullName = ''): void
    {
        include VIEW_PATH . "forms/register.html";
    }

    public function login(): void
    {

    }
}