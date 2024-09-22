<?php

namespace App\Services\Classes;

use App\Models\Rating;
use App\Services\Interfaces\RatingServiceInterface;
use http\Env\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class RatingService implements RatingServiceInterface
{
    /**
     * get ratings for product
     *
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

    /**
     * get a user rating for a product
     *
     * @param int $product_id
     */

    public function getUserRating($product_id)
    {
        $rating = Rating::where('product_id', $product_id)
            ->where('user_id', Auth::id())
            ->first();
        return $rating;
    }

    /**
     * add rating for product
     *
     * @param Request $request
     * @param int $product_id
     * @return array
     */
    public function addRating($request, $product_id)
    {
        $rating = Rating::create([
            'user_id' =>Auth::id(),
            'product_id' => $product_id,
            'rating_value' => $request['rating_value'],
            'comment' => $request['comment'],
        ]);
        return $rating;
    }
}
