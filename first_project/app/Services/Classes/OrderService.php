<?php

namespace App\Services\Classes;

use App\Models\Order;
use App\Models\Product;
use App\Services\Interfaces\OrderServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService implements OrderServiceInterface
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * create an order
     *
     * @param $data
     * @param int $user_id
     * @return bool
     */
    public function createOrder($data, int $user_id): bool
    {
        $sallersProduct = [];
        foreach ($data as $value) {
            $product = $this->productService->findProductById($value['id']);
            if (! $product) {
                return false;
            }
            $id = $product->id;
            $saller_id = $product->saller_id;

            if (!isset($sallersProduct[$saller_id])) {
                $sallersProduct[$saller_id] = [];
            }

            $sallersProduct[$saller_id][] = [
                'id' => $id,
                'count' => $value['count'],
                'price_with_discount' => $value['price_with_discount']
            ];
        }

        foreach ($sallersProduct as $sallerId => $products) {
            $order = Order::create([
                'costumer_id' => $user_id,
                'saller_id' => $saller_id,
                'status_id' => 1,
            ]);
            foreach ($products as $product) {
                DB::table('order_product')->insert([
                    'order_id' => $order->id,
                    'product_id' => $product['id'],
                    'count' => $product['count'],
                    'price_with_discount' => $product['price_with_discount']
                ]);
            }
        }
        return true;
    }

    /**
     * get all orders for specific seller
     *
     * @return array
     */
    public function getSellerOrders()
    {
        $orders = Order::where('saller_id', Auth::id())->get();
        return $orders;
    }
}
