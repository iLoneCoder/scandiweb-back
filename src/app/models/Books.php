<?php

namespace app\models;

class Books extends Products
{
    private float $weight;

    public function __construct(string $sku, string $name, float $price, float $weight)
    {
        parent::__construct($sku, $name, $price);
        $this->weight = $weight;
    }

    public function save(): void
    {
        echo "save book" . PHP_EOL;
    }
}
