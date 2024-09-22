<?php

namespace App\Services\Interfaces;
use App\Models\Rating;
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
     * @param array $request
     * @param int $product_id
     * @return array
     */
    public function addRating($request, $product_id);

    /**
     * get a rating by id
     *
     * @param int $rating_id
     */
    public function getRatingById($rating_id);

    /**
     * edit a rating
     *
     * @param array $request
     * @param Rating $rating
     */
    public function editRating($request, $rating);

    /**
     * delete rating
     *
     * @param Rating $rating
     */
    public function deleteRating(Rating $rating);
}
