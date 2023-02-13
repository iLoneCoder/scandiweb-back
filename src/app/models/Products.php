<?php

namespace app\models;

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
}
