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
            // header("Access-Control-Allow-Origin: *");
            // // header("Access-Control-Allow-Headers: *");
            // header("Access-Control-Allow-Methods: *");
            // // header("Content-Type: application/json");
            if (isset($_SERVER['HTTP_ORIGIN'])) {
                // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
                // you want to allow, and if so:
                header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
                header('Access-Control-Allow-Credentials: true');
                header('Access-Control-Max-Age: 86400'); // cache for 1 day
            }

            // Access-Control headers are received during OPTIONS requests
            if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

                if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                    // may also be using PUT, PATCH, HEAD etc
                    header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");

                if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                    header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

                exit(0);
            }

            $this->router->resolve($method, $requestUri);
        } catch (\Throwable $th) {
            http_response_code(404);
            echo json_encode(["message" => $th->getMessage() . " hh"]);
        }
    }
}