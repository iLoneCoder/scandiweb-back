<?php

namespace app\controllers;

use app\App;
use app\models\Books;
use app\models\Dvd;
use app\models\Furniture;
use app\models\Products;
use app\utils\ProductType;

class ProductsController
{

    public function getProducts()
    {
        $db = App::db();

        $query = "
        select 
            products.id,
            sku,
            name,
            price,
            books.weight,
            dvd.size,
            length,
            width,
            height,
            unit,
            product_type
        from products
        left join books_dimension as books 
            ON books.product_id = products.id
        left join dvd_dimension as dvd
            on dvd.product_id = products.id
        left join furniture_dimension as furniture
            on furniture.product_id = products.id
        ";

        $stmt = $db->prepare($query);

        $stmt->execute();

        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        http_response_code(200);
        echo json_encode($products);
    }

    public function createProduct()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $productType = $data["product_type"];


        if (isset(ProductType::MODELS[$productType])) {
            $class = ProductType::MODELS[$productType];
            if (class_exists($class)) {


                // try {
                    $class = new $class($data);
                // } catch (\Throwable $th) {
                //     http_response_code(400);

                //     echo $th->getMessage();
                //     exit;
                // }


                $class->save();
            }
        } else {
            http_response_code(404);

            echo json_encode(["message" => "Not supported product type"]);
        }

    }

    public function deleteProducts(){
        $data = json_decode(file_get_contentS("php://input"), true) ?? [];
        Products::delete($data);
    }
}