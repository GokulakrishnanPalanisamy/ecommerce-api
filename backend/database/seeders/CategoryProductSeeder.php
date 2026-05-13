<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('category_product')->insert([

            // Lipstick
            [
                'category_id' => 1,
                'product_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Wireless Headphones
            [
                'category_id' => 2,
                'product_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Men T-Shirt
            [
                'category_id' => 3,
                'product_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Smart Watch belongs to Electronics + Clothing
            [
                'category_id' => 2,
                'product_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 3,
                'product_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Sneakers belongs to Clothing + Cosmetics
            [
                'category_id' => 3,
                'product_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
