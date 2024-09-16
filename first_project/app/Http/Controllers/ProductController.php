<?php

namespace App\Http\Controllers;

use App\Services\Classes\ProductService;
use Illuminate\Http\Request;
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
     *     path="/products/allProducts",
     *     summary="get all products",
     *     tags={"Products"},
     *     @OA\Response(
     *      response=200, description="Successful get all products"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function showAllProducts()
    {
        $products = $this->productService->getAllProducts();
        return response()->json($products, 200);
    }
}
