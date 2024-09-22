<?php

namespace App\Services\Interfaces;
use http\Env\Request;

interface RatingServiceInterface
{

    /**
     * @param $request
     * @param int $number
     * @param int $product_id
     * @return array
     */
    public function getProductRatings($request, $number, $product_id);
}
