<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

// 這裡放所有 API 路由
Route::get('/products', [ProductController::class, 'index']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/details', [UserController::class, 'getUserDetails']); // 獲取用戶信息
    Route::put('/user/details', [UserController::class, 'updateUserDetails']); // 更新用戶信息
    Route::post('/user/change-password', [UserController::class, 'changePassword']); // 更改密碼
});