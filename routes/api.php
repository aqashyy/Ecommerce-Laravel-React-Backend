<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\admin\ProductImageController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\TempImageController;
use App\Http\Controllers\front\AccountController;
use App\Http\Controllers\front\OrderController;
use App\Http\Controllers\admin\OrderController as AdminOrderController;
use App\Http\Controllers\Front\ProductController as FrontProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('admin/login',[AuthController::class,'authenticate']);

Route::get('get-latest-products',[FrontProductController::class,'latestProducts']);
Route::get('get-featured-products',[FrontProductController::class,'featuredProducts']);
Route::get('get-categories',[FrontProductController::class,'getCategories']);
Route::get('get-brands',[FrontProductController::class,'getBrands']);
Route::get('get-products',[FrontProductController::class,'getProducts']);
Route::get('get-product/{id}',[FrontProductController::class,'getProduct']);
Route::post('register',[AccountController::class,'register']);
Route::post('login',[AccountController::class,'authenticate']);

Route::group(['middleware' => ['auth:sanctum','checkUserRole']], function() {
    Route::post('save-order',[OrderController::class,'saveOrder']);
    Route::get('get-order-details/{id}',[OrderController::class,'orderDetails']);
});


Route::group(['middleware' => ['auth:sanctum','checkAdminRole']], function() {

    Route::resource('categories',CategoryController::class);
    Route::resource('brands',BrandController::class);

    Route::get('sizes',[SizeController::class,'index']);
    Route::resource('products',ProductController::class);
    Route::post('temp-image',[TempImageController::class,'store']);
    Route::delete('temp-image/{id}',[TempImageController::class,'destroy']);
    Route::post('save-product-image',[ProductController::class,'saveProductImage']);
    Route::get('set-default-product-image',[ProductController::class,'setDefaultProductImage']);
    Route::delete('product-image/{id}',[ProductImageController::class,'destroy']);

    Route::get('orders',[AdminOrderController::class,'index']);
    Route::get('orders/{id}',[AdminOrderController::class,'details']);
    Route::post('orders/{id}',[AdminOrderController::class,'updateOrder']);
});
