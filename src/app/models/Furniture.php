<?php

namespace app\models;

class Furniture extends Products
{
    private float $length;
    private float $width;
    private float $height;

    public function __construct(array $furnitureData)
    {
        $sku = $furnitureData["sku"];
        $name = $furnitureData["name"];
        $price = $furnitureData["price"];
        parent::__construct($sku, $name, $price);
        $this->length = $furnitureData["dimension"]["length"];
        $this->width = $furnitureData["dimension"]["width"];
        $this->height = $furnitureData["dimension"]["height"];
    }

    public function save(): void
    {
        echo "Save furniture" . PHP_EOL;
    }
}
