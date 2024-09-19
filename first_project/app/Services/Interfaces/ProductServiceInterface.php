<?php

namespace App\Services\Interfaces;

use App\Models\Period;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Date;

interface ProductServiceInterface
{
    /**
     * Calculate the days remaining until expiration
     *
     * @param Date $expiration_date
     * @return int
     */
    public function calRemainingDays($expiration_date): int;

    /**
     * Calculate the price with discount
     *
     * @param  integer $price
     * @param Period $period
     * @param integer $remainder_days
     * @return array
     * @throws ModelNotFoundException
     */
    public function getDiscountInfo($price, $period, $remainder_days) : array;

    /**
     * Update the price and discount percentage according to the remaining days until expiration
     *
     * @param  Product $product
     * @param int $remainder_days
     * @throws ModelNotFoundException
     */
    public function refresh_discount_info($product, $remainder_days);

    /**
     * Find the product by id
     *
     * @param integer $product_id
     * @throws ModelNotFoundException
     */
    public function findProductById($product_id);

    /**
     * get many products
     *
     * @param int $number
     * @throws ModelNotFoundException
     */
    public function getManyProducts($number);

    /**
     * filter products by category
     *
     * @param integer $category_id
     * @throws ModelNotFoundException
     */
    public function getProductsByCategoryId($category_id);

    /**
     * filter products by expiration date
     *
     * @param \Carbon\Traits\Date $expiration_date
     * @throws ModelNotFoundException
     */
    public function getProductsByExpirationDate($expiration_date);

    /**
     * filter products by name
     *
     * @param string $product_name
     * @throws ModelNotFoundException
     */
    public function getProductsByName($product_name);
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
