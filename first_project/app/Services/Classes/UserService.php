<?php

namespace App\Services\Classes;

use App\Services\Interfaces\UserServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class UserService implements UserServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    /**
     * find user by id
     *
     * @param int $id
     * @return User
     * @throws ModelNotFoundException
     */
    public function findById(int $id): User
    {
        return User::find($id);
    }

    /**
     * find user by email
     *
     * @param string $email
     * @return User
     * @throws ModelNotFoundException
     */
    public function findByEmail(string $email): User
    {
        return User::where('email', $email)->first();
    }

    /**
     * Create a new user.
     *
     * @param $data.
     * @return User
     * @throws ValidationException
     */
    public function createUser($data): User
    {
        $user = new User;
        $user->full_name = $data['full_name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->bio = '';
        $user->save();
        return $user;
    }

    /**
     * Update user information.
     *
     * @param int $id
     * @param $data
     * @return User
     * @throws ModelNotFoundException
     * @throws ValidationException
     */
    public function updateUser(int $id, $data): User
    {
        $user = User::find($id);
        //
        return $user;
    }

    /**
     * Verify the user's email address.
     *
     * @param string $verificationCode
     * @param int $id
     */
    public function verifyEmailAddress(string $verificationCode, int $id)
    {
        $code = Cache::get('user_id_' . $id);
        if (! $code) {
            return response()->json(['message' => 'Verification code dont exist'], 400);
        }
        if ($code != $verificationCode) {
            return response()->json(['message' => 'Verification code is not correct'], 400);
        }
        $user = $this->findById($id);
        $user->email_verified_at = now();
        $user->save();
        return response()->json(['message' => 'user has been verified']);
    }

    /**
     * Reset password if user forget it
     *
     * @param string $email
     * @return bool
     */
    public function resetPassword(string $email): bool
    {
        return false;
    }

    /**
     * Change the user's password.
     *
     * @param int $id
     * @param string $newPassword
     * @return bool
     * @throws ModelNotFoundException
     * @throws ValidationException
     */
    public function changeUserPassword(int $id, string $newPassword): bool
    {
        return false;
    }

    /**
     * Create token.
     *
     * @param array $data
     */
    public function createToken(array $data)
    {
        $token = JWTAuth::attempt($data);
        if (! $token) {
            return response()->json([
                'message' => 'user login failed'
            ], 400);
        }
        return response()->json([
            'message' => 'user has been login successfuly',
            'Bearer Token' => $token
        ], 200);
    }
}
