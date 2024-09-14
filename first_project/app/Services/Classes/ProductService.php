<?php

namespace App\Services\Classes;

use App\Models\Period;
use App\Models\Product;
use App\Services\Interfaces\ProductServiceInterface;

class ProductService implements ProductServiceInterface
{

    public function addProduct($request)
    {
        $period = Period::create([
            'more_period' => $request->get('more_period'),
            'more_percent' => $request->get('more_percent'),
            'between_percent' => $request->get('between_percent'),
            'less_period' => $request->get('less_period'),
            'less_percent' => $request->get('less_percent'),
        ]);
        $product = Product::create([
            'seller_id' => auth()->id(),
            'name' => $request->get('name'),
            'image_url' => $request->get('image_url'),
            'price' => $request->get('price'),
            'expiration_date' => $request->get('expiration_date'),
            'period_id' => $period->id,
            'category_id' => $request->get('category_id'),
            'count' => $request->get('count'),
            'description' => $request->get('description'),
        ]);

        return $product;
    }
}
