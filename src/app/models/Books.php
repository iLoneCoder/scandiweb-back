<?php

namespace app\models;

use app\App;

class Books extends Products
{
    private float $weight;

    public function __construct(array $bookData)
    {
        $sku = $bookData["sku"];
        $name = $bookData["name"];
        $price = $bookData["price"];
        parent::__construct($sku, $name, $price);
        $this->weight = $bookData["weight"];
    }

    public function save(): void
    {
        $db = App::db();

        if (!$this->sku || !$this->name || !$this->price || !$this->weight) {
            throw new \Exception("Provide required data");
        }

        $querySku = "SELECT * FROM products WHERE sku=?";

        $stmt = $db->prepare($querySku);
        $stmt->execute([$this->sku]);
        $product = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        if(count($product) > 0) {
            http_response_code(400);
            echo json_encode(["message" => "SKU must be unique"]);
            exit;
        }

        echo "save book" . PHP_EOL;
    }
}
