<?php

namespace app\models;

use app\App;
use app\utils\ProductType;

class Furniture extends Products
{
    private float $length;
    private float $width;
    private float $height;

    public function __construct(array $furnitureData)
    {
        try {
            $sku = $furnitureData["sku"];
            $name = $furnitureData["name"];
            $price = $furnitureData["price"];
            parent::__construct($sku, $name, $price);

            $this->length = $furnitureData["dimension"]["length"];
            $this->width = $furnitureData["dimension"]["width"];
            $this->height = $furnitureData["dimension"]["height"];

        } catch (\Throwable $th) {
            http_response_code(400);

            echo json_encode(["message" => "Check keys of provided data"]);
            exit;
        }

    }

    public function save(): void
    {
        $db = APP::db();

        if (!$this->sku || !$this->name || !$this->price || !$this->length || !$this->width || !$this->height) {
            http_response_code(400);
            echo json_encode(["message" => "Provide all requred data"]);
        }

        $query = "SELECT * FROM products WHERE sku=?";
        $stmt = $db->prepare($query);
        $stmt->execute([$this->sku]);
        $product = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (count($product) > 0) {
            http_response_code(409);
            echo json_encode(["message" => "SKU must be unique"]);
            exit;
        }

        //save product
        try {
            $db->beginTransaction();

            //save product
            $query = "INSERT INTO products(sku,name,price,unit,product_type) VALUES(?,?,?,?,?)";
            $stmt = $db->prepare($query);
            $stmt->execute([$this->sku, $this->name, $this->price, null, ProductType::FURNITURE]);
            $productId = $db->lastInsertId();

            //save furniture_dimension
            $query = "INSERT INTO furniture_dimension(length,width,height,product_id) VALUES(?,?,?,?)";
            $stmt = $db->prepare($query);
            $stmt->execute([$this->length, $this->width, $this->height, $productId]);

            http_response_code(201);
            echo json_encode([
                "product" => [
                    "id" => $productId,
                    "sku" => $this->sku,
                    "name" => $this->name,
                    "price" => $this->price,
                    "length" => $this->length,
                    "width" => $this->width,
                    "height" => $this->height
                ]
            ]);

            $db->commit();
            exit;
        } catch (\Throwable $th) {
            $db->rollBack();

            http_response_code(500);
            echo json_encode(["message" => $th->getMessage()]);
        }
    }
}