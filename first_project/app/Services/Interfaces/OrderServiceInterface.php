<?php

namespace App\Services\Interfaces;

use App\Models\Order;

interface OrderServiceInterface
{
    /**
     * create an order
     *
     * @param $data
     * @param int $user_id
     * @return bool
     */
    public function createOrder($data, int $user_id): bool;

    /**
     * get all orders for specific seller
     *
     * @return array
     */
    public function getSellerOrders();

    /**
     * get all orders for specific customer
     *
     * @return array
     */
    public function getCustomerOrders();

    /**
     * @param int $order_id
     */
    public function getOrderById($order_id);

    /**
     * @param Order $order
     * @return bool
     */
    public function acceptOrder($order);

    /**
     * @param $order
     * @return void
     */
    public function rejectOrder($order);
}
