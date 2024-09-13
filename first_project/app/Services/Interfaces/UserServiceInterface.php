<?php

namespace App\Services\Interfaces;

use App\Models\User;

interface UserServiceInterface
{
    /**
     * find user by id
     *
     * @param int $id
     * @return User
     * @throws ModelNotFoundException
     */
    public function findById(int $id): User;

    /**
     * find user by email
     *
     * @param string $email
     * @return User
     * @throws ModelNotFoundException
     */
    public function findByEmail(string $email): User;

    /**
     * Create a new user.
     *
     * @param $data.
     * @return User
     * @throws ValidationException
     */
    public function createUser($data): User;

    /**
     * Update user information.
     *
     * @param int $id
     * @param $data
     * @return User
     * @throws ModelNotFoundException
     * @throws ValidationException
     */
    public function updateUser(int $id, $data): User;

    /**
     * Verify the user's email address.
     *
     * @param string $verificationCode
     * @param int $id
     */
    public function verifyEmailAddress(string $verificationCode, int $id);

    /**
     * Reset password if user forget it
     *
     * @param string $email
     * @return bool
     */
    public function resetPassword(string $email): bool;

    /**
     * Change the user's password.
     *
     * @param int $id
     * @param string $newPassword
     * @return bool
     * @throws ModelNotFoundException
     * @throws ValidationException
     */
    public function changeUserPassword(int $id, string $newPassword): bool;

    /**
     * Create token.
     *
     * @param array $data
     */
    public function createToken(array $data);
}
