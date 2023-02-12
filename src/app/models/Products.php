<?php

namespace app\models;

abstract class Products
{
    private string $sku;
    private string $name;
    private float $price;

    protected function __construct(string $sku, string $name, float $price)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }

    abstract public function save(): void;
}
