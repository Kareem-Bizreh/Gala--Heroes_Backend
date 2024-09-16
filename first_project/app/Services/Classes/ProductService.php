<?php

namespace App\Services\Classes;

use App\Models\Period;
use App\Models\Product;
use App\Services\Interfaces\ProductServiceInterface;

class ProductService implements ProductServiceInterface
{
    /**
     * get all products
     *
     * @throws ModelNotFoundException
     */
    public function getAllProducts()
    {
        $products = Product::all();
        return $products;
    }
}
