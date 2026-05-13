<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{
    public function getAllProducts()
    {
        $products = Cache::remember('products.all', 60, function () {

            return Product::select(
                'id',
                'category_id',
                'name',
                'slug',
                'price',
                'stock',
                'description'
            )->get()->toArray();

        });

        return response()->json([
            'success' => true,
            'message' => 'Products fetched successfully',
            'data' => $products,
        ], 200);
    }

    public function getProduct($id)
    {
        try {

            $product = Cache::remember("products.{$id}", 60, function () use ($id) {

                return Product::select(
                    'id',
                    'category_id',
                    'name',
                    'slug',
                    'price',
                    'stock',
                    'description'
                )->findOrFail($id)->toArray();

            });

            return response()->json([
                'success' => true,
                'message' => 'Product fetched successfully',
                'data' => $product,
            ], 200);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);

        }
    }

    public function createProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'slug' => ['required', 'string', 'unique:products,slug'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);

        $product = Product::create($validated);

        Cache::forget('products.all');

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product,
        ], 201);
    }

    public function updateProduct(Request $request, $id)
    {
        try {

            $product = Product::findOrFail($id);

            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'category_id' => ['required', 'exists:categories,id'],
                'slug' => ['required', 'string', 'unique:products,slug,' . $id],
                'price' => ['required', 'numeric', 'min:0'],
                'stock' => ['required', 'integer', 'min:0'],
                'description' => ['nullable', 'string'],
            ]);

            $product->update($validated);

            Cache::forget('products.all');
            Cache::forget("products.{$id}");

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'data' => $product->fresh(),
            ], 200);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);

        }
    }

    public function deleteProduct($id)
    {
        try {

            $product = Product::findOrFail($id);

            $product->delete();

            Cache::forget('products.all');
            Cache::forget("products.{$id}");

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully',
            ], 200);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);

        }
    }
}
