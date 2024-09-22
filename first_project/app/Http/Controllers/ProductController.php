<?php

namespace App\Http\Controllers;

use App\Services\Classes\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\isEmpty;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @OA\Get(
     *     path="/products/manyProducts/{number}",
     *     summary="get all products",
     *     tags={"Products"},
     *     @OA\Parameter(
     *            name="cursor",
     *            in="query",
     *            required=false,
     *            description="Cursor for pagination",
     *            @OA\Schema(
     *                type="string"
     *            )
     *        ),
     *     @OA\Parameter(
     *           name="number",
     *           in="path",
     *           required=true,
     *           description="Product number",
     *           @OA\Schema(
     *               type="integer"
     *           )
     *       ),
     *     @OA\Response(
     *      response=200, description="Successful get all products"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function showManyProducts(Request $request, $number)
    {
        $products = $this->productService->getManyProducts($request, $number);
        return response()->json($products, 200);
    }

    /**
     * @OA\Get(
     *     path="/products/oneProduct/{product_id}",
     *     summary="get one product",
     *     tags={"Products"},
     *     @OA\Parameter(
     *           name="product_id",
     *           in="path",
     *           required=true,
     *           description="Product id",
     *           @OA\Schema(
     *               type="integer"
     *           )
     *       ),
     *     @OA\Response(
     *      response=200, description="Successful get product"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function showOneProduct($product_id)
    {
        $product = $this->productService->findProductById($product_id);
        if (!$product) {
            return response()->json(['message' => 'product not found'], 404);
        }
        $remainder_days = $this->productService->calRemainingDays($product->expiration_date);
        $this->productService->refresh_discount_info($product, $remainder_days);
        return response()->json([
            'product info' => $product,
            'price with discount' => $product->price_with_discount,
            'discount rate' => $product->discount_rate,
            'remainder days' => $remainder_days,
            'periods info' => $product->period,
            'category info' => $product->category,
            ], 200);
    }

    /**
     * @OA\Get(
     *     path="/products/filterBy/category/{category_id}",
     *     summary="get products by category id",
     *     tags={"Products"},
     *     @OA\Parameter(
     *           name="category_id",
     *           in="path",
     *           required=true,
     *           description="Category id",
     *           @OA\Schema(
     *               type="integer"
     *           )
     *       ),
     *     @OA\Response(
     *      response=200, description="Successful filter products by category"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function filterProductsByCategory($category_id)
    {
        $products = $this->productService->getProductsByCategoryId($category_id);
        return response()->json(['products' => $products], 200);
    }

    /**
     * @OA\Get(
     *     path="/products/filterBy/expirationDate/{expiration_date}",
     *     summary="get products by expiration date",
     *     tags={"Products"},
     *     @OA\Parameter(
     *           name="expiration_date",
     *           in="path",
     *           required=true,
     *           description="Category id",
     *           @OA\Schema(
     *               type="string",
     *               format="date"
     *           )
     *       ),
     *     @OA\Response(
     *      response=200, description="Successful filter products by expiration date"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function filterProductsByExpirationDate($expiration_date)
    {
        $products = $this->productService->getProductsByExpirationDate($expiration_date);
        return response()->json(['products' => $products], 200);
    }

    /**
     * @OA\Get(
     *     path="/products/filterBy/name/{product_name}",
     *     summary="get products by name",
     *     tags={"Products"},
     *     @OA\Parameter(
     *           name="product_name",
     *           in="path",
     *           required=true,
     *           description="Product name",
     *           @OA\Schema(
     *               type="string"
     *           )
     *       ),
     *     @OA\Response(
     *      response=200, description="Successful filter products by name"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function filterProductsByName($product_name)
    {
        $products = $this->productService->getProductsByName($product_name);
        return response()->json(['products' => $products], 200);
    }

    /**
     * @OA\Post(
     *     path="/products/addProduct",
     *     summary="add new product",
     *     tags={"Products"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"more_period", "more_percent", "between_percent", "less_period", "less_percent", "name",
     *      "image_url", "price", "expiration_date", "category_id", "count", "description"},
     *             @OA\Property(
     *                 property="more_period",
     *                 type="integer",
     *                 example="30"
     *             ),
     *             @OA\Property(
     *                 property="more_percent",
     *                  type="integer",
     *                  example="30"
     *             ),
     *             @OA\Property(
     *                 property="between_percent",
     *                  type="integer",
     *                  example="50"
     *              ),
     *             @OA\Property(
     *                 property="less_period",
     *                  type="integer",
     *                  example="15"
     *              ),
     *             @OA\Property(
     *                  property="less_percent",
     *                   type="integer",
     *                   example="70"
     *              ),
     *             @OA\Property(
     *                  property="name",
     *                   type="string",
     *                   example="oil"
     *              ),
     *             @OA\Property(
     *                  property="image_url",
     *                   type="string",
     *                   format="uri",
     *                   example="https://example.com/image.jpg",
     *              ),
     *              @OA\Property(
     *                   property="price",
     *                    type="number",
     *                    format="float",
     *                    example="10000",
     *               ),
     *              @OA\Property(
     *                   property="expiration_date",
     *                    type="string",
     *                    format="date-time",
     *                    example="2024-10-16 08:00:00"
     *               ),
     *              @OA\Property(
     *                    property="category_id",
     *                     type="integer",
     *                     example="1"
     *                ),
     *              @OA\Property(
     *                    property="count",
     *                     type="integer",
     *                     example="10"
     *                ),
     *              @OA\Property(
     *                    property="description",
     *                     type="string",
     *                     example="good oil"
     *                ),
     *
     *         )
     *     ),
     *     @OA\Response(
     *      response=201, description="Successful added",
     *       @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="product added seccessfully"
     *             ),
     *      @OA\Property(
     *                  property="product",
     *                  type="string",
     *                   example="[]"
     *              ),
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid request"),
     *     security={
     *          {"bearer": {}}
     *      }
     * )
     */
    public function addProduct(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'more_period' => 'required | integer | min:0',
            'more_percent' => 'required | integer | min:0 | max:100',
            'between_percent' => 'required | integer | min:0 | max:100',
            'less_period' => 'required | integer | min:0',
            'less_percent' => 'required | integer | min:0 | max:100',
            'name' => 'required | string | min:3 | max:100',
            'image_url' => 'required | url',
            'price' => 'required | numeric | min:0',
            'expiration_date' => 'required | date | after:today',
            'category_id' => 'required | integer | min:1',
            'count' => 'required | integer | min:1',
            'description' => 'required | string | min:3 | max:100',
        ]);
        if ($validatedData->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validatedData->errors(),
            ], 400);
        }
        $validatedData = $validatedData->validated();
        $data = $this->productService->addProduct($validatedData);
        return response()->json([
            'message' => 'product added successfully',
            'product' => $data
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/products/editProduct/{product_id}",
     *     summary="edit product",
     *     tags={"Products"},
     *     @OA\Parameter(
     *          name="product_id",
     *          in="path",
     *          required=true,
     *          description="Product number",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"more_period", "more_percent", "between_percent", "less_period", "less_percent", "name",
     *      "image_url", "price", "expiration_date", "category_id", "count", "description"},
     *             @OA\Property(
     *                 property="more_period",
     *                 type="integer",
     *                 example="30"
     *             ),
     *             @OA\Property(
     *                 property="more_percent",
     *                  type="integer",
     *                  example="30"
     *             ),
     *             @OA\Property(
     *                 property="between_percent",
     *                  type="integer",
     *                  example="50"
     *              ),
     *             @OA\Property(
     *                 property="less_period",
     *                  type="integer",
     *                  example="15"
     *              ),
     *             @OA\Property(
     *                  property="less_percent",
     *                   type="integer",
     *                   example="70"
     *              ),
     *             @OA\Property(
     *                  property="name",
     *                   type="string",
     *                   example="oil"
     *              ),
     *             @OA\Property(
     *                  property="image_url",
     *                   type="string",
     *                   format="uri",
     *                   example="https://example.com/image.jpg",
     *              ),
     *              @OA\Property(
     *                   property="price",
     *                    type="number",
     *                    format="float",
     *                    example="15.5",
     *               ),
     *              @OA\Property(
     *                   property="expiration_date",
     *                    type="string",
     *                    format="date-time",
     *                    example="2024-09-16 08:00:00"
     *               ),
     *              @OA\Property(
     *                    property="category_id",
     *                     type="integer",
     *                     example="1"
     *                ),
     *              @OA\Property(
     *                    property="count",
     *                     type="integer",
     *                     example="10"
     *                ),
     *              @OA\Property(
     *                    property="description",
     *                     type="string",
     *                     example="good oil"
     *                ),
     *
     *         )
     *     ),
     *     @OA\Response(
     *      response=201, description="Successful edited",
     *       @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="product edited seccessfully"
     *             ),
     *      @OA\Property(
     *                  property="product",
     *                  type="string",
     *                   example="[]"
     *              ),
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid request"),
     *     security={
     *           {"bearer": {}}
     *       }
     * )
     */
    public function editProduct(Request $request, $product_id)
    {
        $validatedData = Validator::make($request->all(), [
            'more_period' => 'required | integer | min:0',
            'more_percent' => 'required | integer | min:0 | max:100',
            'between_percent' => 'required | integer | min:0 | max:100',
            'less_period' => 'required | integer | min:0',
            'less_percent' => 'required | integer | min:0 | max:100',
            'name' => 'required | string | min:3 | max:100',
            'image_url' => 'required | url',
            'price' => 'required | numeric | min:0',
            'expiration_date' => 'required | date | after:today',
            'category_id' => 'required | integer | min:1',
            'count' => 'required | integer | min:1',
            'description' => 'required | string | min:3 | max:100',
        ]);
        if ($validatedData->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validatedData->errors(),
            ], 400);
        }
        $product = $this->productService->findProductById($product_id);
        if (!$product) {
            return response()->json(['message' => 'product not found'], 404);
        }
        if ( $product->seller_id != Auth::id()) {
            return response()->json(['message' => 'not allowed'], 403);
        }
        $validatedData = $validatedData->validated();
        $data = $this->productService->editProduct($validatedData, $product);
        return response()->json([
            'message' => 'product edited successfully',
            'product' => $data
        ], 201);
    }

    /**
     * @OA\Delete(
     *     path="/products/deleteProduct/{product_id}",
     *     summary="delete product",
     *     tags={"Products"},
     *     @OA\Parameter(
     *          name="product_id",
     *          in="path",
     *          required=true,
     *          description="Product number",
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
     *                  example="product deleted seccessfully"
     *              ),
     *       @OA\Property(
     *                   property="product",
     *                   type="string",
     *                    example="[]"
     *               ),
     *          )
     *      ),
     *      @OA\Response(response=400, description="Invalid request"),
     *      security={
     *           {"bearer": {}}
     *       }
     *  )
     **/
    public function deleteProduct($product_id)
    {
        $product = $this->productService->findProductById($product_id);
        if (!$product) {
            return response()->json(['message' => 'product not found'], 404);
        }
        if ( $product->seller_id != Auth::id()) {
            return response()->json(['message' => 'not allowed'], 403);
        }
        $deleted_data = $this->productService->deleteProduct($product);
        return response()->json([
            'message' => 'product deleted successfully',
            'product' => $deleted_data
        ],200);
    }
}
