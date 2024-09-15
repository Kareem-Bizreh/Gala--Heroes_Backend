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

    public function showAllProducts()
    {
        $products = $this->productService->getAllProducts();
        if($products->isEmpty())
            return response()->json(['massage' => 'There are no products.'], 200);
        else
            return response()->json($products, 200);
    }
}
