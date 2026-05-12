<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    /**
     * Get all categories
     */
    public function getAllCategories()
    {
        try {

            $categories = Cache::remember('all-categories', 600, function () {

                return Category::select(
                    'id',
                    'name',
                    'slug',
                    'description',
                )->get()->toArray();

            });

            return response()->json([
                'success' => true,
                'data' => $categories
            ], 200);

        } catch (\Exception $e) {

            \Log::error('Get Categories Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch categories'
            ], 500);
        }
    }

    /**
     * Get single category
     */
    public function getCategory($id)
    {
        try {

            $category = Cache::remember("category-{$id}", 600, function () use ($id) {

                return Category::findOrFail($id)->toArray();

            });

            return response()->json([
                'success' => true,
                'data' => $category
            ], 200);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);

        } catch (\Exception $e) {

            \Log::error('Get Category Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    /**
     * Create category
     */
    public function createCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug',
            'description' => 'nullable|string',
        ]);

        try {

            $category = Category::create($validated);

            Cache::forget('all-categories');

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully',
                'data' => $category
            ], 201);

        } catch (\Exception $e) {

            \Log::error('Create Category Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to create category'
            ], 500);
        }
    }

    /**
     * Update category
     */
    public function updateCategory(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug,' . $id,
            'description' => 'nullable|string',
        ]);

        try {

            $category = Category::findOrFail($id);

            $category->update($validated);

            Cache::forget('all-categories');
            Cache::forget("category-{$id}");

            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully',
                'data' => $category->fresh()
            ], 200);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);

        } catch (\Exception $e) {

            \Log::error('Update Category Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update category'
            ], 500);
        }
    }

    /**
     * Delete category
     */
    public function deleteCategory($id)
    {
        try {

            $category = Category::findOrFail($id);

            $category->delete();

            Cache::forget('all-categories');
            Cache::forget("category-{$id}");

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully'
            ], 200);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);

        } catch (\Exception $e) {

            \Log::error('Delete Category Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete category'
            ], 500);
        }
    }
}
