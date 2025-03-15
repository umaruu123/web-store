<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

// 這裡放所有 API 路由
Route::get('/products', [ProductController::class, 'index']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/details', [UserController::class, 'getUserDetails']); // 獲取用戶信息
    Route::put('/user/details', [UserController::class, 'updateUserDetails']); // 更新用戶信息
    Route::post('/user/change-password', [UserController::class, 'changePassword']); // 更改密碼
    Route::get('/addresses', [UserController::class, 'getAddresses']); // 獲取地址信息
    Route::put('/user/update-address', [UserController::class, 'updateAddress']); // 新增地址更新路由
    // 管理員相關路由
    Route::get('/admin/users', [AdminController::class, 'getAllUsers']);
    Route::put('/admin/users/{userId}', [AdminController::class, 'updateUserByAdmin']);
    Route::delete('/admin/users/{userId}', [AdminController::class, 'deleteUserByAdmin']);
});
