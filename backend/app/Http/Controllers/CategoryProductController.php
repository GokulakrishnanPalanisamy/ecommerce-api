<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    public function getProductsByCategoryId($id)
    {
        try {
            $data = Category::findOrFail($id);

            $products = [];

            foreach ($data->products as $product) {
                $products[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'description' => $product->description,
                ];
            }

            return response()->json([
                'products' => $products,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ]);
        }
    }
}
