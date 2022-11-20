<?php

namespace core\application;

class Router
{
    private Track $track;

    public function __construct()
    {
        $routes = require_once "../bootstrap/routes.php";
        $route = $this->setRoute($routes);
        $this->setTrack($routes, $route);
    }

    private function setRoute(array $routes): string
    {
        if (!array_key_exists("REQUEST_URI", $_SERVER) || $_SERVER['REQUEST_URI'] === '' || $_SERVER['REQUEST_URI'] === '/') {
            return '';
        }
        $request_route = ltrim($_SERVER['REQUEST_URI'], '/');
        $questionMarkPosition = strpos($request_route, '?');

        if ($questionMarkPosition > 0) {
            $request_route = substr($request_route, 0, $questionMarkPosition);
        }

        $route = rtrim($request_route, '/');

        if (!$this->isRouteValid($route, $routes)) {
            return 'notfound';
        }

        return $route;
    }

    private function setTrack(array $routes, string $route): void
    {
        if ($this->methodValid($routes[$route])) {
            $this->track = new Track($routes[$route]);
        } else {
            echo "405 Method Not Allowed";
            http_response_code(405);
            exit;
        }
    }

    private function methodValid(array $route): bool
    {
        if ($_SERVER['REQUEST_METHOD'] === strtoupper($route['method'])) {
            return true;
        }

        return false;
    }

    private function isRouteValid($route, $routes): bool
    {
        if (key_exists($route, $routes)) {
            return true;
        }

        return false;
    }

    public function getTrack(): Track
    {
        return $this->track;
    }
}