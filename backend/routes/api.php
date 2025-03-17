<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;

// 這裡放所有 API 路由
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}/details', [ProductController::class, 'showDetails']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/products/category/{categoryName}', [ProductController::class, 'getProductsByCategory']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/details', [UserController::class, 'getUserDetails']); // 獲取用戶信息
    Route::put('/user/details', [UserController::class, 'updateUserDetails']); // 更新用戶信息
    Route::post('/user/change-password', [UserController::class, 'changePassword']); // 更改密碼
    Route::get('/addresses', [UserController::class, 'getAddresses']); // 獲取地址信息
    Route::put('/user/update-address', [UserController::class, 'updateAddress']); // 新增地址更新路由

    // 管理員相關路由
    Route::get('/admin/users', [AdminController::class, 'getAllUsers']);
    Route::post('/admin/users', [AdminController::class, 'addUser']); // 新增用戶
    Route::put('/admin/users/{userId}', [AdminController::class, 'updateUserByAdmin']);
    Route::delete('/admin/users/{userId}', [AdminController::class, 'deleteUserByAdmin']);

    // 管理員產品路由
    Route::get('/admin/products', [ProductController::class, 'index']);
    Route::post('/admin/products', [ProductController::class, 'store']);
    Route::put('/admin/products/{product}', [ProductController::class, 'update']);
    Route::delete('/admin/products/{product}', [ProductController::class, 'destroy']);

    // 管理員類別路由
    Route::post('/admin/categories', [CategoryController::class, 'store']); // 新增類別
    Route::put('/admin/categories/{category}', [CategoryController::class, 'update']); // 編輯類別
    Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy']); // 刪除類別
});