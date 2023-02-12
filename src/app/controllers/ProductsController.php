<?php

namespace app\controllers;

use app\models\Books;
use app\models\Dvd;
use app\models\Furniture;
use app\models\Products;
use app\ProductType;

class ProductsController
{
    public function getProducts() {
        $book = new Dvd("1242", "RED", 50, 3);
        $book->save();
        var_dump($book instanceof Products);
        echo ProductType::BOOK . PHP_EOL;
        echo "<br>";
        echo "getting products list";
    }
}
