<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

// 這裡放所有 API 路由
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}/details', [ProductController::class, 'showDetails']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/products/category/{categoryName}', [ProductController::class, 'getProductsByCategory']);

Route::middleware('auth:sanctum')->group(function () {
    // 用戶相關路由
    Route::get('/user/details', [UserController::class, 'getUserDetails']); // 獲取用戶信息
    Route::put('/user/details', [UserController::class, 'updateUserDetails']); // 更新用戶信息
    Route::post('/user/change-password', [UserController::class, 'changePassword']); // 更改密碼
    Route::get('/addresses', [UserController::class, 'getAddresses']); // 獲取地址信息
    Route::put('/user/update-address', [UserController::class, 'updateAddress']); // 新增地址更新路由

    // 購物車相關路由
    Route::get('/cart', [CartController::class, 'getCart']);
    Route::post('/cart/add', [CartController::class, 'addToCart']);
    Route::delete('/cart/remove/{productId}', [CartController::class, 'removeFromCart']);
    Route::delete('/cart/clear', [CartController::class, 'clearCart']);

    // 用戶訂單相關路由
    Route::post('/orders', [OrderController::class, 'createOrder']); // 創建訂單
    Route::get('/orders', [OrderController::class, 'getOrders']); // 獲取用戶訂單列表
    Route::get('/orders/{orderId}', [OrderController::class, 'getOrderDetails']); // 獲取用戶訂單詳情
    Route::delete('/orders/{orderId}', [OrderController::class, 'cancelOrder']); // 取消訂單

    // 管理員相關路由
    Route::prefix('admin')->group(function () {
        // 管理員用戶管理
        Route::get('/users', [AdminController::class, 'getAllUsers']);
        Route::post('/users', [AdminController::class, 'addUser']); // 新增用戶
        Route::put('/users/{userId}', [AdminController::class, 'updateUserByAdmin']);
        Route::delete('/users/{userId}', [AdminController::class, 'deleteUserByAdmin']);

        // 管理員產品管理
        Route::get('/products', [ProductController::class, 'index']);
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{product}', [ProductController::class, 'update']);
        Route::delete('/products/{product}', [ProductController::class, 'destroy']);

        // 管理員類別管理
        Route::post('/categories', [CategoryController::class, 'store']); // 新增類別
        Route::put('/categories/{category}', [CategoryController::class, 'update']); // 編輯類別
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy']); // 刪除類別

        // 管理員訂單管理
        Route::get('/orders', [OrderController::class, 'getAdminOrders']); // 獲取所有訂單（管理員用）
        Route::get('/orders/{orderId}', [OrderController::class, 'getAdminOrderDetails']); // 獲取訂單詳情（管理員用）
        Route::put('/orders/{orderId}/status', [OrderController::class, 'updateOrderStatus']); // 更新訂單狀態（管理員用）
    });
});     