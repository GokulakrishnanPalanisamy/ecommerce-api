<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Mappers\ProductMappers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response As StatusCode;

class ProductController extends Controller
{
    public function getAllProducts()
    {
        try {

            $products = Cache::remember('allProducts', 600, function () {
                return ProductMappers::mapProducts(Product::all());
            });

            return response()->json([
                'success' => true,
                'message' => 'Products fetched successfully',
                'data' => $products,
            ], StatusCode::HTTP_OK);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Products Model not found',
            ], StatusCode::HTTP_NOT_FOUND);

        } catch (\Exception $e) {

            \Log::error('Get Products Error' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], StatusCode::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    public function getProduct($id)
    {
        try {

            $product = Cache::remember("product.{$id}", 60, function () use ($id) {
                return ProductMappers::mapProduct(Product::findOrFail($id));
            });

            return response()->json([
                'success' => true,
                'message' => 'Product fetched successfully',
                'data' => $product,
            ], StatusCode::HTTP_OK);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Product Model not found',
            ], StatusCode::HTTP_NOT_FOUND);

        } catch (\Exception $e) {

            \Log::error('Get Product Error' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], StatusCode::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    public function createProduct(ProductRequest $request)
    {
        try {

            $validated = $request->validated();
            $product = Product::create([
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'stock' => $validated['stock'],
            ]);

            if (!empty($validated['category_ids'])) {
                $product->categories()->attach($validated['category_ids']);
            }

            Cache::forget('all-products');

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'data' => ProductMappers::mapProduct($product),
            ], StatusCode::HTTP_CREATED);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Product Model not found',
            ], StatusCode::HTTP_NOT_FOUND);

        }  catch (\Exception $e) {

            \Log::error('Create Product Error' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }


    }

    public function updateProduct(ProductRequest $request, $id)
    {

        try {

            $product = Product::findOrFail($id);

            $validated = $request->validated();

            $product->update([
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'stock' => $validated['stock'],
            ]);

            if (!empty($validated['category_ids'])) {
                $product->categories()->sync($validated['category_ids']);
            }

            Cache::forget('all-products');
            Cache::forget("product.{$id}");

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'data' => ProductMappers::mapProduct($product),
            ], StatusCode::HTTP_OK);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], StatusCode::HTTP_NOT_FOUND);

        } catch (ValidationException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'error' => $e->getMessage(),
            ], StatusCode::HTTP_UNPROCESSABLE_ENTITY);

        } catch (\Exception $e) {

            \Log::error('Update Product Error' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], StatusCode::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    public function deleteProduct($id)
    {
        try {

            $product = Product::findOrFail($id);

            $product->delete();

            Cache::forget('all-products');
            Cache::forget("product.{$id}");

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
