<?php

namespace app\models;

class Furniture extends Products
{
    private float $length;
    private float $width;
    private float $height;

    public function __construct(string $sku, string $name, float $price, array $dimension)
    {
        parent::__construct($sku, $name, $price);
        $this->length = $dimension["length"];
        $this->width = $dimension["width"];
        $this->height = $dimension["height"];
    }

    public function save(): void
    {
        echo "Save furniture" . PHP_EOL;
    }
}
