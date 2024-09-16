<?php

namespace App\Services\Interfaces;

use App\Models\Product;
use App\Models\User;
use http\Env\Request;

interface ProductServiceInterface
{
    /**
     * get all products
     *
     * @throws ModelNotFoundException
     */
    public function getAllProducts();

    /**
     * add product
     *
     * @param array $data
     * @return Product
     * @throws ModelNotFoundException
     */
    public function addProduct($data);

    /**
     * edit product by id
     *
     * @param array $data
     * @param Product $product
     * @return Product
     * @throws ModelNotFoundException
     */
    public function editProduct($data, $product);

    /**
     * delete product by id
     *
     * @param Product $product
     * @return Product
     * @throws ModelNotFoundException
     */
    public function deleteProduct($product);
}
