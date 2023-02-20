<?php

namespace app\utils;

class ProductType
{
    public const BOOK = "book";
    public const DVD = "dvd";
    public const FURNITURE = "furniture";

    public const MODELS = [
        ProductType::BOOK => "app\models\Books",
        ProductType::DVD => "app\models\Dvd",
        ProductType::FURNITURE => "app\models\\Furniture"
    ];
}
