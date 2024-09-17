<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //add new data:
        Category::create([
            'name_en' => 'Fruits',
            'name_ar'=>'فواكه'
        ]);
        Category::create([
            'name_en' => 'Vegetables',
            'name_ar'=>'خضروات'
        ]);
        Category::create([
            'name_en' => 'Meat',
            'name_ar'=>'لحوم'
        ]);
        Category::create([
            'name_en' => 'Fish',
            'name_ar'=>'أسماك'
        ]);
        Category::create([
            'name_en' => 'Dairy products',
            'name_ar'=>'منتجات الألبان'
        ]);
        Category::create([
            'name_en' => 'Baked goods',
            'name_ar'=>'مخبوزات'
        ]);
        Category::create([
            'name_en' => 'Natural juices',
            'name_ar'=>'عصائر طبيعية'
        ]);
        Category::create([
            'name_en' => 'Sweets and cakes',
            'name_ar'=>'حلويات وكيك'
        ]);
        Category::create([
            'name_en' => 'Medicines and Health Supplies',
            'name_ar'=>'أدوية ومستلزمات صحية'
        ]);
        Category::create([
            'name_en' => 'Cosmetics and Personal Care',
            'name_ar'=>'مستحضرات تجميل وعناية شخصية'
        ]);
        Category::create([
            'name_en' => 'Cleaning products',
            'name_ar'=>'منتجات تنظيف'
        ]);
    }
}
