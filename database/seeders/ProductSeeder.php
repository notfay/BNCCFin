<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create sample products for each category
        $categories = Category::all();
        
        foreach ($categories as $category) {
            // Example products for each category
            for ($i = 1; $i <= 5; $i++) {
                $name = $category->name . ' Item ' . $i;
                $price = rand(10000, 1000000);
                $quantity = rand(1, 100);
                
                Product::create([
                    'category_id' => $category->id,
                    'name' => $name,
                    'price' => $price,
                    'quantity' => $quantity,
                    'image' => null // No image by default
                ]);
            }
        }
    }
}