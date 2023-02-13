<?php

namespace app;

class Routes
{
    private array $routes;

    private function register(string $method, string $route, array $action)
    {
        $this->routes[$method][$route] = $action;
    }

    public function get(string $route, array $action)
    {
        $this->register("GET", $route, $action);
    }

    public function post(string $route, array $action)
    {
        $this->register("POST", $route, $action);
    }

    public function resolve(string $method, string $requestUri)
    {
        $action = $this->routes[$method][$requestUri] ?? null;

        if (!$action) {
            throw new \app\exceptions\RouteNotFoundExceptions();
        }

        if (is_array($action)) {
            [$class, $method] = $action;

            if (class_exists($class)) {
                $class = new $class();
                if (method_exists($class, $method)) {
                    return $class->$method();
                }
            }
        }
    }
}
