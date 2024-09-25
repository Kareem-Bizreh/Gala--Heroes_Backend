<?php

namespace App\Services\Classes;

use App\Services\Interfaces\OrderServiceInterface;

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
     */
    public function createOrder($data, int $user_id)
    {
        //
    }
}
