<?php

namespace App\Services\Classes;

use App\Models\Period;
use App\Models\Product;
use App\Services\Interfaces\ProductServiceInterface;
use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class ProductService implements ProductServiceInterface
{

    /**
     * Calculate the days remaining until expiration
     *
     * @param Date $expiration_date
     * @return int
     */
    public function calRemainingDays($expiration_date) : int
    {
        $current_date=Carbon::now();
        $carbon_expiration_date=Carbon::parse($expiration_date);
        $remainder_days=$current_date->diffInDays($carbon_expiration_date);
        return ceil($remainder_days);
    }

    /**
     * Calculate the price with discount
     *
     * @param  integer $price
     * @param Period $period
     * @param integer $remainder_days
     * @return array
     * @throws ModelNotFoundException
     */
    public function getDiscountInfo($price, $period, $remainder_days): array
    {

        $more_period=$period['more_period'];
        $more_percent=$period['more_percent'];
        $between_percent=$period['between_percent'];
        $less_period=$period['less_period'];
        $less_percent=$period['less_percent'];

        if ($remainder_days>$more_period)
        {
            $discount_rate= $more_percent;
            $price_with_discount= $price - ($more_percent/100) * $price;
        }
        else if($remainder_days>$less_period)
        {
            $discount_rate= $between_percent;
            $price_with_discount= $price - ($between_percent/100) * $price;
        }
        else
        {
            $discount_rate= $less_percent;
            $price_with_discount= $price - ($less_percent/100) * $price;
        }

        return ['price_with_discount' => $price_with_discount, 'discount_rate' => $discount_rate];
    }

    /**
     * Update the price and discount percentage according to the remaining days until expiration
     *
     * @param Product $product
     * @param $remainder_days
     * @throws ModelNotFoundException
     */
    public function refresh_discount_info($product, $remainder_days)
    {
        $discount_info = $this->getDiscountInfo($product->price, $product->period, $remainder_days);
        $product->discount_rate = $discount_info['discount_rate'];
        $product->price_with_discount = $discount_info['price_with_discount'];
        $product->save();
    }

    /**
     * Find the product by id
     *
     * @param integer $product_id
     * @throws ModelNotFoundException
     */
    public function findProductById($product_id)
    {
        return Product::where('id', $product_id)->first();
    }

    /**
     * get many products
     *
     * @param integer $number
     * @throws ModelNotFoundException
     */
    public function getManyProducts($number)
    {
        $products = Product::take($number)
            ->get(['id', 'name', 'image_url', 'price', 'expiration_date', 'period_id']);
        foreach ($products as $product)
        {
            $remainder_days = $this->calRemainingDays($product->expiration_date);
            $this->refresh_discount_info($product, $remainder_days);
        }
        return $products;
    }


    /**
     * add product
     *
     * @param array $data
     * @return Product
     * @throws ModelNotFoundException
     */
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

    /**
     * edit product by id
     *
     * @param array $data
     * @param Product $product
     * @return Product
     * @throws ModelNotFoundException
     */
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

    /**
     * delete product by id
     *
     * @param Product $product
     * @return Product
     * @throws ModelNotFoundException
     */
    public function deleteProduct($product){
        $product->delete();
        return $product;
    }
}
