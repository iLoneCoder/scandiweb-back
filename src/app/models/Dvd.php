<?php

namespace app\models;

use app\App;
use app\utils\ProductType;
use app\utils\UnitTypes;

class Dvd extends Products
{
    private float $size;

    public function __construct(array $dvdData)
    {
        try {
            $sku = $dvdData["sku"];
            $name = $dvdData["name"];
            $price = $dvdData["price"];
            parent::__construct($sku, $name, $price);
            $this->size = $dvdData["size"];
        } catch (\Throwable $th) {
            http_response_code(400);
            echo json_encode(["message" => "Check keys of provided data"]);
            exit;
        }

    }

    public function save(): void
    {
        $db = APP::db();

        if (!$this->sku || !$this->name || !$this->price || !$this->size) {
            http_response_code(400);
            echo json_encode(["message" => "Provide required data"]);
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

        try {
            //save product
            $db->beginTransaction();
            $query = "INSERT INTO products(sku,name,price,unit,product_type) VALUES(?,?,?,?,?)";
            $stmt = $db->prepare($query);
            $stmt->execute([$this->sku, $this->name, $this->price, UnitTypes::MB, ProductType::DVD]);
            $productId = $db->lastInsertId();

            //save dvd_dimension
            $query = "INSERT INTO dvd_dimension(size,product_id) VALUES(?,?)";
            $stmt = $db->prepare($query);
            $stmt->execute([$this->size, $productId]);

            http_response_code(201);
            echo json_encode([
                "product" => [
                    "id" => $productId,
                    "sku" => $this->sku,
                    "name" => $this->name,
                    "price" => $this->price,
                    "unit" => UnitTypes::MB,
                    "product_type" => ProductType::DVD
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