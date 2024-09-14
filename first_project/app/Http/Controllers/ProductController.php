<?php

namespace App\Http\Controllers;

use App\Services\Classes\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function addProduct($request)
    {
        $validatedData = Validator::make($request->all(),[
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
        ]);
        if ($validatedData->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validatedData->errors(),
            ], 400);
        }
        $validatedData = $validatedData->validated();
        return response()->json($this->productService->addProduct($validatedData),201);
    }


}
