<?php

namespace App\Http\Controllers;

use App\Services\Classes\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
     *                  property="price_with_discount",
     *                  type="integer"
     *              )
     *           ),
     *           example={{
     *             "id": 1,
     *             "count": 5,
     *             "price_with_discount": 500
     *              }, {
     *             "id": 4,
     *             "count": 3,
     *             "price_with_discount": 1000
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
        foreach ($request->all() as $product) {
            $data = Validator::make($product, [
                'id' => 'required|min:1',
                'count' => 'required|min:1',
                'price_with_discount' => 'required'
            ]);

            if ($data->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $data->errors(),
                ], 400);
            }
            $data = $data->validated();
        }
        if (! $this->orderService->createOrder($request->all(), Auth::id())) {
            return response()->json([
                'message' => 'faild to add order'
            ], 400);
        }

        return response()->json([
            'message' => 'order added successfully'
        ], 200);
    }

    /**
     * @OA\Get(
     *      path="/orders/showSellerOrders",
     *      summary="show orders for specific seller",
     *      tags={"Orders"},
     * @OA\Response(
     *       response=200, description="Successfully get orders",
     *        @OA\JsonContent(
     *              @OA\Property(
     *                  property="orders",
     *                  type="string",
     *                  example="[]"
     *              ),
     *          )
     *      ),
     * @OA\Response(response=400, description="Invalid request"),
     *      security={
     *          {"bearer": {}}
     *      }
     *     )
     */
    public function showSellerOrders()
    {
        $orders = $this->orderService->getSellerOrders();
        return response()->json(['orders' => $orders], 200);
    }
}
