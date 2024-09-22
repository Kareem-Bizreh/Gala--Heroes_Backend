<?php

namespace App\Services\Classes;

use App\Models\Product;
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
     * @param array $request
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

    /**
     * get a rating by id
     *
     * @param int $rating_id
     */
    public function getRatingById($rating_id)
    {
        $rating = Rating::where('id', $rating_id)->first();
        return $rating;
    }

    /**
     * edit a rating
     *
     * @param array $request
     * @param Rating $rating
     */
    public function editRating($request, $rating)
    {
        $updated_rating = $rating->update([
            'rating_value' => $request['rating_value'],
            'comment' => $request['comment'],
        ]);
        return $updated_rating;
    }

    /**
     * delete rating
     *
     * @param Rating $rating
     */
    public function deleteRating(Rating $rating)
    {
        $deleted_rating = $rating->delete();
        return $deleted_rating;
    }

    /**
     * Calculate product Rating
     *
     * @param int $product_id
     * @return float|int
     */
    public function calProductRating(int $product_id)
    {
        $ratings = Rating::where('product_id', $product_id)
            ->get('rating_value');
        if($ratings->isEmpty())
        {
            return null;
        }
        $sum = 0;
        foreach ($ratings as $rating) {
            $sum += $rating->rating_value;
        }
        return $sum/count($ratings);
    }
}
