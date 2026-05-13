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
                'id' => 1,
                'name' => 'Cosmetics',
                'slug' => 'cosmetics',
                'description' => 'Cosmetics products',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Electronic products',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Clothing',
                'slug' => 'clothing',
                'description' => 'Fashion and clothing products',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
