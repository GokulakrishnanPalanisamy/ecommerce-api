<?php

namespace App\Http\Controllers;

use App\Mappers\CategoryMapper;
use App\Mappers\ProductMappers;
use App\Models\Category;
use App\Models\Product;
use Symfony\Component\HttpFoundation\Response As StatusCode;

class CategoryProductController extends Controller
{
    public function getProductsByCategoryId($id)
    {
        try {
            $data = Category::findOrFail($id);

            $products = [];

            foreach ($data->products as $product) {
                $products[] = ProductMappers::mapProduct($product);
            }

            return response()->json([
                'message' => 'Product fetched successfully',
                'data' => $products,
            ], StatusCode::HTTP_OK);

        } catch (\Exception $e) {

            \Log::error('Get Product by Category ID' . $e->getMessage());

            return response()->json([
                'message' => 'Something went wrong',
            ], StatusCode::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    public function getCategoryByProductId($id)
    {
        try {
            $product = Product::findOrFail($id);

            $categories = [];

            foreach ($product->categories as $category) {
                $categories[] = CategoryMapper::mapCategory($category);
            }

            return response()->json([
                'message' => 'Category fetched successfully',
                'data' => $categories,
            ], StatusCode::HTTP_OK);

        } catch (\Exception $e) {

            \Log::error('Get Category by Product ID Error' . $e->getMessage());

            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
