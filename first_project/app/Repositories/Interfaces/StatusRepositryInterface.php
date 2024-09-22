<?php

namespace App\Repositories\Interfaces;

interface StatusRepositryInterface
{
    /**
     * get all status
     */
    public function getAllStatuses();

    /**
     * get status by id
     * @param int $id
     */
    public function getStatusById(int $id);
}