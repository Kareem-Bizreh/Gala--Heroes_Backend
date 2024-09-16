<?php

namespace App\Services\Interfaces;

use App\Models\Product;
use App\Models\User;

interface ProductServiceInterface
{
    /**
     * get all products
     *
     * @throws ModelNotFoundException
     */
    public function getAllProducts();

    public function addProduct($data);
}
