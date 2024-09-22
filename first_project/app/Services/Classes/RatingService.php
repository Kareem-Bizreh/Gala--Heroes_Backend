<?php

namespace App\Services\Classes;

use App\Models\Rating;
use App\Services\Interfaces\RatingServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RatingService implements RatingServiceInterface
{
    /**
     * @param $request
     * @param int $number
     * @param int $product_id
     * @return array
     */
    public function getProductRatings($request, $number, $product_id)
    {
        $cursor = $request->query('cursor');

        $ratings = Rating::where('product_id', $product_id)
            ->cursorPaginate($number, ['*'], 'cursor', $cursor);

        return $ratings;
    }
}
