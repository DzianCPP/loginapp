<?php

use core\controllers\AppController;
use core\controllers\UserController;

return [
    '' => [
        'controller' => AppController::class,
        'action' => 'index',
        'method' => 'GET'
    ],

    'public' => [
        'controller' => AppController::class,
        'action' => 'index',
        'method' => 'GET'
    ],

    'user/register' => [
        'controller' => UserController::class,
        'action' => 'register',
        'method' => 'POST'
    ],

    'user/login' => [
        'controller' => UserController::class,
        'action' => 'login',
        'method' => 'GET'
    ]
];