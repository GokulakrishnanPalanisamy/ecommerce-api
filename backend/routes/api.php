<?php

use Illuminate\Support\Facades\Route;

Route::post('/register', 'App\Http\Controllers\UserController@register');
Route::post('/login', 'App\Http\Controllers\UserController@login');

Route::middleware('auth:sanctum')->group(function () {
    // logout
    Route::post('/logout', 'App\Http\Controllers\UserController@logout');

    //categories routes
    Route::prefix('/category')->group(function () {
        Route::get('/', 'App\Http\Controllers\CategoryController@getAllCategories');
        Route::get('/{id}', 'App\Http\Controllers\CategoryController@getCategory');
        Route::post('/', 'App\Http\Controllers\CategoryController@createCategory');
        Route::put('/{id}', 'App\Http\Controllers\CategoryController@updateCategory');
        Route::delete('/{id}', 'App\Http\Controllers\CategoryController@deleteCategory');
    });

    // products route
    Route::prefix('/product')->group(function () {
        Route::get('/', 'App\Http\Controllers\ProductController@getAllProducts');
        Route::get('/{id}', 'App\Http\Controllers\ProductController@getProduct');
        Route::post('/', 'App\Http\Controllers\ProductController@createProduct');
        Route::put('/{id}', 'App\Http\Controllers\ProductController@updateProduct');
        Route::delete('/{id}', 'App\Http\Controllers\ProductController@deleteProduct');
    });
});
