<?php

namespace App\Services\Classes;

use App\Models\Period;
use App\Models\Product;
use App\Services\Interfaces\ProductServiceInterface;
use http\Env\Request;
use function PHPUnit\Framework\isEmpty;

class ProductService implements ProductServiceInterface
{
    public function getAllProducts()
    {
        $products = Product::all();
        return $products;
    }
}
