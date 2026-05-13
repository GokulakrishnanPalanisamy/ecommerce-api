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
        Category::insert([
            [
                'name' => 'cosmetics',
                'slug' => 'cosmetics',
                'description' => 'Cosmetics description',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'electronics',
                'slug' => 'electronics',
                'description' => 'Electronics description',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'clothing',
                'slug' => 'clothing',
                'description' => 'Clothing description',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
