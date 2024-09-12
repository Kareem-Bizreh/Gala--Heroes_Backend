<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerify;
use App\Services\Classes\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * @OA\Info(title="My First API", version="0.1")
 */
class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Post(
     *     path="/users/register",
     *     summary="register users",
     *     tags={"Users"},
     *     @OA\Parameter(
     *      name="full_name",
     *      description="name of the user",
     *      example="Harry Potter",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="string"
     *      )
     *     ),
     *     @OA\Response(response=200, description="Successful register and verification code send"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function register(Request $request)
    {
        $validateDate = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validateDate->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validateDate->errors(),
            ], 400);
        }

        $verificationCode = Str::random(6);
        $user = $this->userService->createUser($validateDate);
        Cache::put('user_id_' . $user->id, $verificationCode, now()->addMinutes(5));
        Mail::to($user->email)->send(new EmailVerify($user->full_name, $verificationCode));
        return response()->json([
            'message' => 'Verification code sent',
            'id' => $user->id
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/users/verifyEmail",
     *     summary="verify users",
     *     tags={"Users"},
     *     @OA\Response(response=200, description="Successful verify"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function verifyEmail(Request $request)
    {
        $data = Validator::make($request->all(), [
            'verify_code' => 'required|string|min:6|max:6',
            'id' => 'required'
        ]);

        if ($data->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $data->errors(),
            ], 400);
        }

        return $this->userService->verifyEmailAddress($data['verify_code'], $data['id']);
    }
}
