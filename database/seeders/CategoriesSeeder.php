<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // أقسام رئيسية
        $electronics = Category::create([
            'name' => 'Electronics',
            'image' => 'electronics.jpg',
            'parent_id' => null, // لا يوجد أب
        ]);

        $fashion = Category::create([
            'name' => 'Fashion',
            'image' => 'fashion.jpg',
            'parent_id' => null,
        ]);

        $home = Category::create([
            'name' => 'Home & Garden',
            'image' => 'home.jpg',
            'parent_id' => null,
        ]);

        // أقسام فرعية تحت Electronics
        Category::create([
            'name' => 'Mobiles',
            'image' => 'mobiles.jpg',
            'parent_id' => $electronics->id,
        ]);

        Category::create([
            'name' => 'Laptops',
            'image' => 'laptops.jpg',
            'parent_id' => $electronics->id,
        ]);

        // أقسام فرعية تحت Fashion
        Category::create([
            'name' => 'Men Clothing',
            'image' => 'men.jpg',
            'parent_id' => $fashion->id,
        ]);

        Category::create([
            'name' => 'Women Clothing',
            'image' => 'women.jpg',
            'parent_id' => $fashion->id,
        ]);

        // أقسام فرعية تحت Home & Garden
        Category::create([
            'name' => 'Furniture',
            'image' => 'furniture.jpg',
            'parent_id' => $home->id,
        ]);

        Category::create([
            'name' => 'Kitchen',
            'image' => 'kitchen.jpg',
            'parent_id' => $home->id,
        ]);
    }
}
