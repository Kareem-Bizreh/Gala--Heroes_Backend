<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerify;
use App\Services\Classes\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"full_name", "email" , "password" , "password_confirmation"},
     *             @OA\Property(
     *                 property="full_name",
     *                 type="string",
     *                 example="Harry Potter"
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 example="test@example.com"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 example="password123"
     *             ),
     *             @OA\Property(
     *                 property="password_confirmation",
     *                 type="string",
     *                 example="password123"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *      response=200, description="Successful register and verification code send to user with id",
     *       @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Verification code sent"
     *             ),
     *             @OA\Property(
     *                 property="id",
     *                 type="integer",
     *                 example=1
     *             ),
     *         )
     *     ),
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
        $validateDate = $validateDate->validated();
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
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"verify_code", "id"},
     *             @OA\Property(
     *                 property="verify_code",
     *                 type="string",
     *                 example="123456"
     *             ),
     *             @OA\Property(
     *                 property="id",
     *                 type="integer",
     *                 example=1
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *      response=200, description="Successful verify",
     *       @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="user has been verified"
     *             ),
     *         )
     *     ),
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
        $data = $data->validated();

        return $this->userService->verifyEmailAddress($data['verify_code'], $data['id']);
    }

    /**
     * @OA\Post(
     *     path="/users/login",
     *     summary="login user",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 example="test@example.com"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 example="password"
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *      response=200, description="Successful login",
     *       @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="user has been login successfuly"
     *             ),
     *             @OA\Property(
     *                 property="Bearer Token",
     *                 type="string",
     *                 example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
     *             ),
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function login(Request $request)
    {
        $data = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8',
        ]);

        if ($data->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $data->errors(),
            ], 400);
        }
        $data = $data->validated();

        $user = $this->userService->findByEmail($data['email']);
        if (! $user->email_verified_at) {
            return response()->json([
                'message' => 'user has not been verified',
            ], 400);
        }

        return $this->userService->createToken($data);
    }

    /**
     * @OA\Post(
     *     path="/users/logout",
     *     summary="logout user",
     *     tags={"Users"},
     *     @OA\Response(
     *      response=200, description="Successful logout",
     *       @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="user has been logout successfuly"
     *             ),
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid request"),
     *     security={
     *         {"bearer": {}}
     *     }
     * )
     */
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'user has been logout successfuly'
        ], 200);
    }
}
