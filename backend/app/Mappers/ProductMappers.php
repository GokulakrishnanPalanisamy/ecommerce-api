<?php

namespace App\Mappers;

use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ProductMappers
{

    public static function mapProduct($product)
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'price' => $product->price,
            'stock' => $product->stock,
            'description' => $product->description
        ];
    }

    public static function mapProducts($products)
    {
        return $products->map(function ($product) {
            return [
                   'id' => $product->id,
                   'name' => $product->name,
                   'slug' => $product->slug,
                   'price' => $product->price,
                   'stock' => $product->stock,
                   'description' => $product->description
           ];
       })->toArray();
    }
}
