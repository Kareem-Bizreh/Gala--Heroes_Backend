<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statuses')->insert([
            'name_en' => 'Waiting for seller',
            'name_ar' => 'بانتظار البائع'
        ]);
//        DB::table('statuses')->insert([
//            'name_en' => 'Order Being Prepared',
//            'name_ar' => 'يتم تجهيز الطلب'
//        ]);
//        DB::table('statuses')->insert([
//            'name_en' => 'On the way',
//            'name_ar' => 'على الطريق'
//        ]);
//        DB::table('statuses')->insert([
//            'name_en' => 'Waiting for buyer',
//            'name_ar' => 'بانتظار المشتري'
//        ]);
        DB::table('statuses')->insert([
            'name_en' => 'Order has been accepted',
            'name_ar' => 'تم قبول الطلب'
        ]);
        DB::table('statuses')->insert([
            'name_en' => 'Order has been rejected',
            'name_ar' => 'تم رفض الطلب'
        ]);
    }
}
