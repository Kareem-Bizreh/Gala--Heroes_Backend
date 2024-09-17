<?php

namespace App\Repositories\Classes;

use App\Repositories\Interfaces\ContactRepositryInterface;
use Illuminate\Support\Facades\DB;

class ContactRepositry implements ContactRepositryInterface
{
    /**
     * get all of contact type
     */
    public function allContactType()
    {
        return DB::table('contact_type')->get();
    }

    /**
     * get contact type by id
     *
     * @param int $id
     * @throws ModelNotFound
     */
    public function getTypeById(int $id)
    {
        return DB::table('contact_type')->find($id);
    }

    /**
     * get contact information for user by
     *
     * @param int $user_id
     */
    public function getInfo(int $user_id)
    {
        return DB::table('contact_info')->where('user_id', '=', $user_id)->get();
    }

    /**
     * add contact information for user
     *
     * @param int $user_id
     * @param array $data
     */
    public function addInfo(int $user_id, array $data)
    {
        DB::table('contact_info')->insert([
            'type_id' => $data['id'],
            'value' => $data['value'],
            'user_id' => $user_id
        ]);
    }
}
