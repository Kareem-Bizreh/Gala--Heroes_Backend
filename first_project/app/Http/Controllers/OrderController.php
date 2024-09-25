<?php

namespace App\Http\Controllers;

use App\Services\Classes\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @OA\Post(
     *     path="/orders/createOrder",
     *     summary="create order",
     *     tags={"Orders"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *         type="array",
     *          @OA\Items(
     *              type="object",
     *              @OA\Property(
     *                  property="id",
     *                  type="integer",
     *                  example=1
     *              ),
     *              @OA\Property(
     *                  property="count",
     *                  type="integer",
     *                  example=5
     *              )
     *           ),
     *           @OA\Items(
     *              type="object",
     *              @OA\Property(
     *                  property="id",
     *                  type="integer"
     *              ),
     *              @OA\Property(
     *                  property="count",
     *                  type="integer"
     *              ),
     *              @OA\Property(
     *                  property="price",
     *                  type="integer"
     *              )
     *           ),
     *           example={{
     *             "id": 1,
     *             "count": 5,
     *             "price": 500
     *              }, {
     *             "id": 4,
     *             "count": 3,
     *             "price": 1000
     *           }}
     *         )
     *     ),
     *     @OA\Response(
     *      response=200, description="Successfully order created",
     *       @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="order added successfully"
     *             ),
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid request"),
     *     security={
     *         {"bearer": {}}
     *     }
     * )
     */
    public function createOrder(Request $request)
    {
        // $data = Validator::make($request->all(), [
        //     'id' => 'required',
        //     'value' => 'required|string',
        // ]);

        // if ($data->fails()) {
        //     return response()->json([
        //         'message' => 'Validation failed',
        //         'errors' => $data->errors(),
        //     ], 400);
        // }
        // $data = $data->validated();
    }
}
