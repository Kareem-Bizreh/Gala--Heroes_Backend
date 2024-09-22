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
            'name_en' => 'Being Prepared',
            'name_ar' => 'يتم تجهيز الطلب'
        ]);
        DB::table('statuses')->insert([
            'name_en' => 'On the way',
            'name_ar' => 'على الطريق'
        ]);
        DB::table('statuses')->insert([
            'name_en' => 'Delivery Failed',
            'name_ar' => 'فشل التوصيل'
        ]);
        DB::table('statuses')->insert([
            'name_en' => 'Delivered',
            'name_ar' => 'تم توصيله'
        ]);
        DB::table('statuses')->insert([
            'name_en' => 'Order Being Prepared',
            'name_ar' => 'يتم تجهيز الطلب'
        ]);
        DB::table('statuses')->insert([
            'name_en' => 'Order Canceled',
            'name_ar' => 'تم الغاء الطلب'
        ]);
        DB::table('statuses')->insert([
            'name_en' => 'Pending Payment',
            'name_ar' => 'بانتظار الدفع'
        ]);
        DB::table('statuses')->insert([
            'name_en' => 'Payment Completed',
            'name_ar' => 'تم الدفع'
        ]);
        DB::table('statuses')->insert([
            'name_en' => 'Order Returned',
            'name_ar' => 'تم إرجاع الطلب'
        ]);
    }
}