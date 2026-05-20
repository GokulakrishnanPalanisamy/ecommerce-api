<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Mappers\CategoryMapper;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response As StatusCode;

class CategoryController extends Controller
{
    /**
     * Get all categories
     */
    public function getAllCategories()
    {
        try {

            $categories = Cache::remember('all-categories', 600, function () {
               return CategoryMapper::mapCategory(Category::all());
            });

            return response()->json([
                'success' => true,
                'data' => $categories
            ], StatusCode::HTTP_OK);

        } catch (\Exception $e) {

            \Log::error('Get Categories Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch categories'
            ], StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get single category
     */
    public function getCategory($id)
    {
        try {

            $category = Cache::remember("category-{$id}", 600, function () use ($id) {
                return CategoryMapper::mapCategory(Category::findOrFail($id));
            });

            return response()->json([
                'success' => true,
                'data' => $category
            ], StatusCode::HTTP_OK);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], StatusCode::HTTP_NOT_FOUND);

        } catch (\Exception $e) {

            \Log::error('Get Category Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ], StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Create category
     */
    public function createCategory(CategoryRequest $request)
    {

        try {

            $validated = $request->validated();

            $category = Category::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully',
                'data' => CategoryMapper::mapCategory($category)
            ], StatusCode::HTTP_CREATED);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Category Model not found'
            ], StatusCode::HTTP_NOT_FOUND);

        } catch (\Exception $e) {

            \Log::error('Create Category Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to create category'
            ], StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update category
     */
    public function updateCategory(CategoryRequest $request, $id)
    {
        try {

            $validated = $request->validated();

            $category = Category::findOrFail($id);

            $category->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully',
                'data' => CategoryMapper::mapCategory($category->refresh())
            ], StatusCode::HTTP_OK);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], StatusCode::HTTP_NOT_FOUND);

        } catch (\Exception $e) {

            \Log::error('Update Category Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update category'
            ], StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Delete category
     */
    public function deleteCategory($id)
    {
        try {

            $category = Category::with('products')->findOrFail($id);

            $associated_product_ids = $category['products']->pluck('id')->toArray();

            foreach ($associated_product_ids as $associated_product_id) {
                Cache::forget("product.{$associated_product_id}");
            }

            $category->products()->detach();

            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully'
            ], StatusCode::HTTP_OK);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], StatusCode::HTTP_NOT_FOUND);

        } catch (\Exception $e) {

            \Log::error('Delete Category Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete category'
            ], StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
