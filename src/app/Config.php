<?php

namespace app;

class Config
{
    private array $config;

    public function __construct($env)
    {
        $this->config = [
            "host" => $env["HOST"],
            "dbname" => $env["DB_NAME"],
            "username" => $env["USERNAME"],
            "password" => $env["PASSWORD"]
        ];
    }

    public function getConfig()
    {
        return $this->config;
    }
}
