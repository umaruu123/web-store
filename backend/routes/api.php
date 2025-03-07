<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

// 這裡放所有 API 路由
Route::get('/products', [ProductController::class, 'index']);
Route::post('/register', [UserController::class, 'register']);
