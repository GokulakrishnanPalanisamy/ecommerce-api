<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            [
                'id' => 1,
                'name' => 'Lipstick',
                'slug' => 'lipstick',
                'price' => 499.99,
                'stock' => 100,
                'description' => 'Premium matte lipstick',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Wireless Headphones',
                'slug' => 'wireless-headphones',
                'price' => 2999.00,
                'stock' => 50,
                'description' => 'Bluetooth wireless headphones',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Men T-Shirt',
                'slug' => 'men-t-shirt',
                'price' => 799.00,
                'stock' => 200,
                'description' => 'Cotton round neck t-shirt',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Smart Watch',
                'slug' => 'smart-watch',
                'price' => 4999.00,
                'stock' => 70,
                'description' => 'Fitness smart watch',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'name' => 'Sneakers',
                'slug' => 'sneakers',
                'price' => 2499.00,
                'stock' => 90,
                'description' => 'Casual white sneakers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
