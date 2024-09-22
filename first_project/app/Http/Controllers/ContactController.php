<?php

namespace App\Http\Controllers;

use App\Repositories\Classes\ContactRepositry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    protected $contactRepositry;

    public function __construct(ContactRepositry $contactRepositry)
    {
        $this->contactRepositry = $contactRepositry;
    }

    /**
     * @OA\Get(
     *     path="/contacts/allForUser/{user_id}",
     *     summary="show contact information for user",
     *     tags={"Contacts"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         description="ID of the user",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *      response=200, description="Successfully get inforamtion"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function showContactInfo(int $user_id)
    {
        $contactInfo = $this->contactRepositry->getInfo($user_id);
        foreach ($contactInfo as $info) {
            $contactType = $this->contactRepositry->getTypeById($info->type_id);
            $info->type = $contactType;
        }
        return response()->json($contactInfo, 200);
    }

    /**
     * @OA\Get(
     *     path="/contacts/allTypes",
     *     summary="show all contact type to user when he add contact information",
     *     tags={"Contacts"},
     *     @OA\Response(response=200, description="succesful show all contact type"),
     *     @OA\Response(response=400, description="Invalid request"),
     *     security={
     *         {"bearer": {}}
     *     }
     * )
     */
    public function showContactType()
    {
        return response()->json($this->contactRepositry->allContactType(), 200);
    }

    /**
     * @OA\Post(
     *     path="/contacts/addContactInfo",
     *     summary="add contact information for users",
     *     tags={"Contacts"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id", "value"},
     *             @OA\Property(
     *                 property="id",
     *                 type="integer",
     *                 example=5
     *             ),
     *             @OA\Property(
     *                 property="value",
     *                 type="string",
     *                 example="test@example.com"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *      response=200, description="Successfully contact inforamtion added",
     *       @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="information added successfully"
     *             ),
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid request"),
     *     security={
     *         {"bearer": {}}
     *     }
     * )
     */
    public function addInfo(Request $request)
    {
        $data = Validator::make($request->all(), [
            'id' => 'required',
            'value' => 'required|string',
        ]);

        if ($data->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $data->errors(),
            ], 400);
        }
        $data = $data->validated();

        $this->contactRepositry->addInfo(Auth::id(), $data);

        return response()->json([
            'message' => 'information added successfully'
        ], 200);
    }
}