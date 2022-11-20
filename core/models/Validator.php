<?php

namespace core\models;

class Validator
{
    public function makeDataSafe($data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }

    public function userDataValid(string $email, string $fullName): bool
    {
        if (!$this->nameValid($fullName) || !$this->emailValid($email)) {
            return false;
        }
        return true;
    }

    private function emailValid(string $email): bool
    {
        if (empty($email)) {
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    private function nameValid(string $fullName): bool
    {
        $firstName = substr($fullName, 0, strpos($fullName, " ", 0));
        $lastName = ltrim(substr($fullName, strpos($fullName, " ", 0), strlen($fullName)));

        if (!preg_match("/^[a-z ,.'-]+$/i", $firstName) || !preg_match("/^[a-z ,.'-]+$/i", $lastName)) {
            return false;
        }
        return true;
    }
}