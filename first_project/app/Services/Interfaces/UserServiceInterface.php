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
     * Change the user's password.
     *
     * @param int $id
     * @param string $newPassword
     * @throws ModelNotFoundException
     */
    public function changeUserPassword(int $id, string $newPassword);

    /**
     * Create token.
     *
     * @param array $data
     */
    public function createToken(array $data);

    /**
     * Verify the user's to create new password .
     *
     * @param string $verificationCode
     * @param int $id
     */
    public function verifyPassword(string $verificationCode, int $id);
}
