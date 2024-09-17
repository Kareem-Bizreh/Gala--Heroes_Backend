<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('contact_type')->insert([
            'type_en' => 'facbook',
            'type_ar' => 'فيسبوك'
        ]);
        DB::table('contact_type')->insert([
            'type_en' => 'what\'s up',
            'type_ar' => 'واتساب'
        ]);
        DB::table('contact_type')->insert([
            'type_en' => 'telegram',
            'type_ar' => 'تيليغرام'
        ]);
        DB::table('contact_type')->insert([
            'type_en' => 'instagram',
            'type_ar' => 'انستغرام'
        ]);
        DB::table('contact_type')->insert([
            'type_en' => 'email',
            'type_ar' => 'الايميل'
        ]);
        DB::table('contact_type')->insert([
            'type_en' => 'phone number',
            'type_ar' => 'رقم الهاتف'
        ]);
        DB::table('contact_type')->insert([
            'type_en' => 'address',
            'type_ar' => 'العنوان'
        ]);
    }
}
