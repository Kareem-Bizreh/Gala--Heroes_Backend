<?php

namespace App\Services\Interfaces;

interface OrderServiceInterface
{
    /**
     * create an order
     *
     * @param $data
     * @param int $user_id
     */
    public function createOrder($data, int $user_id);
}
