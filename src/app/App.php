<?php

namespace app;

class App
{
    private Routes $router;
    private static \PDO $db;

    public function __construct(Routes $router, Config $config)
    {
        $this->router = $router;

        $configArray = $config->getConfig();

        $dsn = "mysql:host=" . $configArray["host"] . ";dbname=" . $configArray["dbname"];
        $username = $configArray["username"];
        $password = $configArray["password"];
        
        try {
            static::$db = new \PDO($dsn, $username, $password);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage());
        }

    }

    public static function db(): \PDO
    {
        return static::$db;
    }

    public function run(string $method, string $requestUri)
    {
        try {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Headers: *");
            header("Content-Type: application/json");
            $this->router->resolve($method, $requestUri);
        } catch (\Throwable $th) {
            http_response_code(404);
            echo json_encode(["message" => $th->getMessage() . " hh"]);
        }
    }
}
