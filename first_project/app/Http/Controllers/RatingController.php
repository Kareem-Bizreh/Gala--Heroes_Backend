<?php

namespace App\Http\Controllers;

use App\Services\Classes\RatingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


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

    /**
     * @OA\Post(
     *       path="/ratings/addRating/{product_id}",
     *       summary="add new Rating",
     *       tags={"Ratings"},
     * @OA\Parameter(
     *            name="product_id",
     *            in="path",
     *            required=true,
     *            description="Product id",
     *            @OA\Schema(
     *                type="integer"
     *            )
     *        ),
     * @OA\RequestBody(
     *           required=true,
     *           @OA\JsonContent(
     *               required={"rating_value", "comment"},
     *      @OA\Property(
     *                   property="rating_value",
     *                   type="float",
     *                   example="4.7"
     *               ),
     *      @OA\Property(
     *                    property="comment",
     *                     type="string",
     *                     example="vary good!"
     *                ),
     *     )
     * ),
     * @OA\Response(
     *        response=201, description="Successful added",
     *         @OA\JsonContent(
     *               @OA\Property(
     *                   property="message",
     *                   type="string",
     *                   example="rating added seccessfully"
     *               ),
     *               @OA\Property(
     *                    property="rating",
     *                    type="string",
     *                     example="[]"
     *                ),
     *           )
     *       ),
     *       @OA\Response(response=400, description="Invalid request"),
     *       security={
     *            {"bearer": {}}
     *        }
     *     )
     */
    public function addRating(Request $request, $product_id)
    {
        if($this->ratingService->getUserRating($product_id))
        {
            return response()->json(['message' => 'You have already rated this product'], 400);
        }
        $validatedData = validator::make($request->all(), [
            'rating_value' => 'required | numeric | between:1,5',
            'comment' => 'required | string'
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validatedData->errors(),
            ], 400);
        }
        $validatedData = $validatedData->validated();
        $data = $this->ratingService->addRating($validatedData,$product_id);

        return response()->json([
            'message' => 'rating added successfully',
            'rating' => $data
        ], 201);
    }

    /**
     * @OA\Put(
     *       path="/ratings/editRating/{rating_id}",
     *       summary="edit Rating",
     *       tags={"Ratings"},
     * @OA\Parameter(
     *            name="rating_id",
     *            in="path",
     *            required=true,
     *            description="rating id",
     *            @OA\Schema(
     *                type="integer"
     *            )
     *        ),
     * @OA\RequestBody(
     *           required=true,
     *           @OA\JsonContent(
     *               required={"rating_value", "comment"},
     *      @OA\Property(
     *                   property="rating_value",
     *                   type="float",
     *                   example="4.7"
     *               ),
     *      @OA\Property(
     *                    property="comment",
     *                     type="string",
     *                     example="vary good!"
     *                ),
     *     )
     * ),
     * @OA\Response(
     *        response=201, description="Successful edited",
     *         @OA\JsonContent(
     *               @OA\Property(
     *                   property="message",
     *                   type="string",
     *                   example="rating edited seccessfully"
     *               ),
     *               @OA\Property(
     *                    property="rating",
     *                    type="string",
     *                     example="[]"
     *                ),
     *           )
     *       ),
     *       @OA\Response(response=403, description="",
     *          @OA\JsonContent(
     *                @OA\Property(
     *                    property="message",
     *                    type="string",
     *                    example="You are not allowed to edit this rating"
     *                ),
     *              )
     *       ),
     *       @OA\Response(response=400, description="Invalid request"),
     *       security={
     *            {"bearer": {}}
     *        }
     *     )
     */
    public function editRating(Request $request, $rating_id)
    {
        $rating = $this->ratingService->getRatingById($rating_id);
        if(!$rating)
        {
            return response()->json(['message' => 'rating not found'], 404);
        }
        if($rating->user_id != Auth::id())
        {
            return response()->json(['message' => 'You are not allowed to edit this rating'], 403);
        }
        $validatedData = validator::make($request->all(), [
            'rating_value' => 'required | numeric | between:1,5',
            'comment' => 'required | string'
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validatedData->errors(),
            ], 400);
        }
        $validatedData = $validatedData->validated();
        $data = $this->ratingService->editRating($validatedData,$rating);

        return response()->json([
            'message' => 'rating edited successfully',
            'rating' => $data
        ], 201);
    }

    /**
     * @OA\Delete(
     *     path="/ratings/deleteRating/{rating_id}",
     *     summary="delete rating",
     *     tags={"Ratings"},
     *     @OA\Parameter(
     *          name="rating_id",
     *          in="path",
     *          required=true,
     *          description="Rating number",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *       response=200, description="Successful deleted",
     *        @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="rating deleted seccessfully"
     *              ),
     *          )
     *      ),
     *     @OA\Response(response=403, description="",
     *           @OA\JsonContent(
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="You are not allowed to delete this rating"
     *                 ),
     *               )
     *        ),
     *      @OA\Response(response=400, description="Invalid request"),
     *      security={
     *           {"bearer": {}}
     *       }
     *  )
     **/
    public function deleteRating($rating_id)
    {
        $rating = $this->ratingService->getRatingById($rating_id);
        if(!$rating)
        {
            return response()->json(['message' => 'rating not found'], 404);
        }
        if($rating->user_id != Auth::id())
        {
            return response()->json(['message' => 'You are not allowed to delete this rating'], 403);
        }
        $deleted_data = $this->ratingService->deleteRating($rating);
        return response()->json([
            'message' => 'rating deleted successfully',
        ],200);
    }


    /**
     * @OA\Get(
     * path="/ratings/showProductRating/{product_id}",
     * summary="Get ratings for a specific product",
     * tags={"Ratings"},
     * @OA\Parameter(
     *    name="product_id",
     *    in="path",
     *    required=true,
     *    description="ID of the product",
     *    @OA\Schema(
     *        type="integer"
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Successful retrieval of product rating",
     *    @OA\JsonContent(
     *        @OA\Property(
     *            property="product rating",
     *            type="number",
     *            format="float",
     *            example=4.5
     *        )
     *    )
     * ),
     * @OA\Response(
     *    response=404,
     *    description="No ratings found for this product",
     *    @OA\JsonContent(
     *        @OA\Property(
     *            property="message",
     *            type="string",
     *            example="There are no ratings for this product"
     *        )
     *    )
     * ),
     * @OA\Response(
     *    response=400,
     *    description="Invalid request"
     * )
     * )
     */


    public function showProductRating($product_id)
    {
        $product_rating = $this->ratingService->calProductRating($product_id);
        if(!$product_rating)
        {
            return response()->json(['message' => 'there are no ratings for this product'], 404);
        }
        return response()->json(['total rating' => $product_rating],200);
    }
}
