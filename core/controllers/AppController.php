<?php

namespace core\controllers;

class AppController
{
    public function index(): void
    {
        require VIEW_PATH . "forms/login.html";
    }

    public function notFound(): void
    {
        require VIEW_PATH . "404.html";
    }
}