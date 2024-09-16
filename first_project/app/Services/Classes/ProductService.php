<?php

namespace App\Services\Classes;

use App\Models\Period;
use App\Models\Product;
use App\Services\Interfaces\ProductServiceInterface;
use Illuminate\Support\Facades\Auth;

class ProductService implements ProductServiceInterface
{
    /**
     * get all products
     *
     * @throws ModelNotFoundException
     */
    public function getAllProducts()
    {
        $products = Product::all();
        return $products;
    }

    public function findProductById($id)
    {
        return Product::where('id', $id)->first();
    }


    public function addProduct($data)
    {
        $period = Period::create([
            'more_period' => $data['more_period'],
            'more_percent' => $data['more_percent'],
            'between_percent' => $data['between_percent'],
            'less_period' => $data['less_period'],
            'less_percent' => $data['less_percent'],
        ]);
        $product = Product::create([
            'seller_id' => Auth::id(),
            'name' => $data['name'],
            'image_url' => $data['image_url'],
            'price' => $data['price'],
            'expiration_date' => $data['expiration_date'],
            'period_id' => $period->id,
            'category_id' => $data['category_id'],
            'count' => $data['count'],
            'description' => $data['description']
        ]);

        return $product;
    }

    public function editProduct($data, $product)
    {
        Period::where('id', $product['period_id'])->update([
           'more_period' => $data['more_period'],
            'more_percent' => $data['more_percent'],
            'between_percent' => $data['between_percent'],
            'less_period' => $data['less_period'],
            'less_percent' => $data['less_percent'],
        ]);
        $product->update([
           'name' => $data['name'],
           'image_url' => $data['image_url'],
           'price' => $data['price'],
           'expiration_date' => $data['expiration_date'],
           'category_id' => $data['category_id'],
           'count' => $data['count'],
           'description' => $data['description']
        ]);
        $product->save();
        return $product;
    }
}
