<?php

namespace app\models;

use app\App;

abstract class Products
{
    protected string $sku;
    protected string $name;
    protected float $price;

    protected function __construct(string $sku, string $name, float $price)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }

    abstract public function save(): void;

    public static function delete(array $data): void
    {
        $db = APP::db();
        if (count($data) > 0 && count($data["productsId"]) > 0) {
            $query = "DELETE FROM products WHERE id IN(" . str_repeat("?,", count($data["productsId"]) - 1) . "?)";
            $stmt = $db->prepare($query);
            $stmt->execute($data["productsId"]);

            echo json_encode(["message" => "Provided products has been deleted"]);
            exit;
        }

        http_response_code(400);
        echo json_encode(["message" => "Provide data to delete"]);
        exit;
    }
}