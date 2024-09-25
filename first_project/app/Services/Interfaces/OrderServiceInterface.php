<?php

namespace App\Services\Interfaces;

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
}
