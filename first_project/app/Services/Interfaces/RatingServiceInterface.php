<?php

namespace App\Services\Interfaces;
use http\Env\Request;

interface RatingServiceInterface
{

    /**
     * get ratings for product
     *
     * @param $request
     * @param int $number
     * @param int $product_id
     * @return array
     */
    public function getProductRatings($request, $number, $product_id);

    /**
     * get a user rating for a product
     *
     * @param int $product_id
     */

    public function getUserRating($product_id);

    /**
     * add rating for product
     *
     * @param Request $request
     * @param int $product_id
     * @return array
     */
    public function addRating($request, $product_id);
}
