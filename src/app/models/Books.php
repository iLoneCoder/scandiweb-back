<?php

namespace app\models;

use app\App;
use app\utils\ProductType;
use app\utils\UnitTypes;

class Books extends Products
{
    private float $weight;

    public function __construct(array $bookData)
    {
        try {
            $sku = $bookData["sku"];
            $name = $bookData["name"];
            $price = $bookData["price"];
            parent::__construct($sku, $name, $price);
            $this->weight = $bookData["weight"];
        } catch (\Throwable $th) {
            http_response_code(400);
            echo json_encode(["message" => "Check keys of provided data"]);
            exit;
        }

    }

    public function save(): void
    {
        $db = App::db();

        if (!$this->sku || !$this->name || !$this->price || !$this->weight) {
            http_response_code(400);
            echo json_encode(["message" => "Provide required data"]);
        }

        $querySku = "SELECT * FROM products WHERE sku=?";

        $stmt = $db->prepare($querySku);
        $stmt->execute([$this->sku]);
        $product = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        if (count($product) > 0) {
            http_response_code(409);
            echo json_encode(["message" => "SKU must be unique"]);
            exit;
        }

        try {
            $db->beginTransaction();

            //save products
            $query = "INSERT INTO products(sku,name,price,unit,product_type) VALUES(?,?,?,?,?)";

            $stmt = $db->prepare($query);
            $stmt->execute([$this->sku, $this->name, $this->price, UnitTypes::KG, ProductType::BOOK]);
            $productId = $db->lastInsertId();

            //save book-dimension
            $query = "INSERT INTO books_dimension(weight, product_id) VALUES(?,?)";
            $stmt = $db->prepare($query);
            $stmt->execute([$this->weight, $productId]);

            http_response_code(201);
            echo json_encode([
                "product" => [
                    "id" => $productId,
                    "sku" => $this->sku,
                    "name" => $this->name,
                    "price" => $this->price,
                    "unit" => UnitTypes::KG,
                    "product_type" => ProductType::BOOK
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