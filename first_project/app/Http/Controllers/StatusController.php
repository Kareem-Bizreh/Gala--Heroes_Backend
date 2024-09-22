<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Classes\StatusRepositry;

class StatusController extends Controller
{
    protected $statusRepositry;

    public function __construct(StatusRepositry $statusRepositry)
    {
        $this->statusRepositry = $statusRepositry;
    }

    /**
     * @OA\Get(
     *     path="/statuses/allStatuses",
     *     summary="get all statuses",
     *     tags={"Statuses"},
     *     @OA\Response(response=200, description="succesful get all statuses"),
     *     @OA\Response(response=400, description="Invalid request"),
     * )
     */
    public function allStatuses()
    {
        return response()->json($this->statusRepositry->getAllStatuses(), 200);
    }
}