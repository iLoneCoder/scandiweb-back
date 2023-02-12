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

        static::$db = new \PDO($dsn, $username, $password);
    }

    public function run(string $method, string $requestUri)
    {
        try {
            $this->router->resolve($method, $requestUri);
        } catch (\Throwable $th) {
            http_response_code(404);
            echo json_encode(["message" => "page not found"]);
        }
        
    }
}
