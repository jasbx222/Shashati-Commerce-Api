<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // جلب بعض الأقسام
        $mobiles = Category::where('name', 'Mobiles')->first();
        $laptops = Category::where('name', 'Laptops')->first();
        $menClothing = Category::where('name', 'Men Clothing')->first();
        $furniture = Category::where('name', 'Furniture')->first();

        // منتجات مرتبطة بالقسم Mobiles
        Product::create([
            'name' => 'iPhone 15',
            // 'image' => 'iphone15.jpg',
            'description' => 'Apple iPhone 15 with 128GB storage',
            'quantity' => 20,
            'price' => 1200,
            'price_after' => 1100,
            'category_id' => $mobiles?->id,
            'is_offer' => true,
        ]);

        Product::create([
            'name' => 'Samsung Galaxy S24',
            // 'image' => 'samsung_s24.jpg',
            'description' => 'Samsung flagship smartphone',
            'quantity' => 30,
            'price' => 1000,
            'price_after' => null,
            'category_id' => $mobiles?->id,
            'is_offer' => false,
        ]);



        // منتجات مرتبطة بالقسم Men Clothing
        Product::create([
            'name' => 'Men Cotton T-Shirt',
            // 'image' => 'tshirt_men.jpg',
            'description' => 'High quality cotton t-shirt for men',
            'quantity' => 50,
            'price' => 20,
            'price_after' => 15,
            'category_id' => $menClothing?->id,
            'is_offer' => true,
        ]);

        // منتجات مرتبطة بالقسم Furniture
        Product::create([
            'name' => '3-Seater Sofa',
            // 'image' => 'sofa.jpg',
            'description' => 'Comfortable fabric sofa for living room',
            'quantity' => 10,
            'price' => 600,
            'price_after' => null,
            'category_id' => $furniture?->id,
            'is_offer' => false,
        ]);
    }
}
