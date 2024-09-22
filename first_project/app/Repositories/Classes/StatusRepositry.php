<?php

namespace App\Repositories\Classes;

use App\Repositories\Interfaces\StatusRepositryInterface;
use Illuminate\Support\Facades\DB;

class StatusRepositry implements StatusRepositryInterface
{
    /**
     * get all status
     */
    public function getAllStatuses()
    {
        return DB::table('statuses')->get();
    }

    /**
     * get status by id
     * @param int $id
     */
    public function getStatusById(int $id)
    {
        return DB::table('statuses')->find($id);
    }
}