<?php


declare(strict_types=1);

require_once __DIR__ . "/../vendor/autoload.php";

use app\App;
use app\Config;
use app\controllers\ProductsController;
use app\models\Books;
use app\Routes;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$router = new Routes();

$router->get("/api/get-products", [ProductsController::class, "getProducts"]);
$router->post("/api/create-product", [ProductsController::class, "createProduct"]);
$router->delete("/api/delete-products", [ProductsController::class, "deleteProducts"]);
// echo "<pre>";
// var_dump($_SERVER);
// echo "<pre>";


(new App($router, new Config($_ENV)))->run($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"]);
