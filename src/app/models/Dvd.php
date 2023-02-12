<?php

namespace app\models;

class Dvd extends Products
{
    private float $size;

    public function __construct(string $sku, string $name, float $price, float $size)
    {
        parent::__construct($sku, $name, $price);
        $this->size = $size;
    }

    public function save(): void
    {
        echo "save Dvd" . PHP_EOL;
    }
}
