<?php

namespace App\Mappers;

class CategoryMapper
{
    public static function mapCategory($categories)
    {
        // Single model
        if ($categories instanceof \App\Models\Category) {

            return [
                'id' => $categories->id,
                'name' => $categories->name,
                'slug' => $categories->slug,
                'description' => $categories->description,
            ];
        }

        // Collection
        return $categories->map(function ($category) {

            return [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'description' => $category->description,
            ];

        })->toArray();
    }
}
