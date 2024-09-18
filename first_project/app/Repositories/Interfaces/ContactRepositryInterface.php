<?php

namespace App\Repositories\Interfaces;


interface ContactRepositryInterface
{
    /**
     * get all of contact type
     */
    public function allContactType();

    /**
     * get contact type by id
     *
     * @param int $id
     */
    public function getTypeById(int $id);

    /**
     * add contact information for user
     *
     * @param int $user_id
     * @param array $data
     */
    public function addInfo(int $user_id, array $data);
}
