<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerify;
use App\Services\Classes\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {
        $validateDate = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $verificationCode = Str::random(6);
        $user = $this->userService->createUser($validateDate);
        Cache::put('user_id_' . $user->id, $verificationCode, now()->addMinutes(5));
        Mail::to($user->email)->send(new EmailVerify($user->full_name, $verificationCode));
        return response()->json([
            'message' => 'Verification code sent',
            'id' => $user->id
        ], 200);
    }

    public function verifyCode(Request $request)
    {
        $data = $request->validate([
            'verify_code' => 'required|string|min:6|max:6',
            'id' => 'required'
        ]);
        return $this->userService->verifyEmailAddress($data['verify_code'], $data['id']);
    }
}
