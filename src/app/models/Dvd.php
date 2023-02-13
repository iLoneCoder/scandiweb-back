<?php

namespace app\models;

class Dvd extends Products
{
    private float $size;

    public function __construct(array $dvdData)
    {
        $sku = $dvdData["sku"];
        $name = $dvdData["name"];
        $price = $dvdData["price"];
        parent::__construct($sku, $name, $price);
        $this->size = $dvdData["size"];
    }

    public function save(): void
    {
        echo "save Dvd" . PHP_EOL;
    }
}
