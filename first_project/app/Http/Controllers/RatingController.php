<?php

namespace App\Http\Controllers;

use App\Services\Classes\RatingService;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    protected $ratingService;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    /**
     * @OA\Get(
     * path="/ratings/showProductRatings/{number}/{product_id}",
     * summary="get ratings for one product",
     * tags={"Ratings"},
     * @OA\Parameter(
     *             name="cursor",
     *             in="query",
     *             required=false,
     *             description="Cursor for pagination",
     *             @OA\Schema(
     *                 type="string"
     *             )
     *         ),
     * @OA\Parameter(
     *            name="number",
     *            in="path",
     *            required=true,
     *            description="Ratings number",
     *            @OA\Schema(
     *                type="integer"
     *            )
     *        ),
     * @OA\Parameter(
     *            name="product_id",
     *            in="path",
     *            required=true,
     *            description="Product id",
     *            @OA\Schema(
     *                type="integer"
     *            )
     *        ),
     * @OA\Response(
     *       response=200, description="Successful get ratings"),
     *      @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function showProductRatings(Request $request, $number, $product_id)
    {
        $ratings = $this->ratingService->getProductRatings($request, $number, $product_id);
        return response()->json(['ratings' => $ratings], 200);
    }
}
