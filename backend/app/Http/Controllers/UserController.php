<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail; 
use Carbon\Carbon;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // 驗證請求資料
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:7|regex:/[a-zA-Z]/|regex:/[0-9]/',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'gender' => 'required|in:male,female,other',
            'address1' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'state' => 'required|string',
            'zip' => 'required|string',
            'phone' => 'required|string',
        ]);

        // 創建使用者
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'gender' => $request->gender,
            'address1' => $request->address1,
            'address2' => $request->address2 ?? null,
            'city' => $request->city,
            'country' => $request->country,
            'state' => $request->state,
            'zip' => $request->zip,
            'phone' => $request->phone,
        ]);

        Mail::to($user->email)->send(new WelcomeEmail($user));

        return response()->json(['message' => 'User registered successfully! A welcome email has been sent.'], 201);
    }

    // UserController.php
        public function login(Request $request)
        {
            // 驗證請求資料
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // 檢查用戶是否存在
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json(['message' => 'Email not found'], 404);
            }

            // 檢查密碼是否正確
            if (!Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'Incorrect password'], 401);
            }

            // 生成 Token（這裡使用 Laravel Sanctum 或 Passport）
            $token = $user->createToken('authToken')->plainTextToken;

            // 返回 Token 和用戶信息
            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user,
            ], 200);
        }
        public function getUserDetails(Request $request)
        {
            // 獲取當前登錄用戶
            $user = $request->user();

            // 返回用戶信息
            return response()->json([
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone,
            ]);
        }
        public function updateUserDetails(Request $request)
        {
            $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required|string',
            ]);

            $user = $request->user();
            $user->update($request->only(['first_name', 'last_name', 'email', 'phone']));

            return response()->json(['message' => 'User details updated successfully!']);
        }

        public function changePassword(Request $request)
        {
            $request->validate([
                'currentPassword' => 'required',
                'newPassword' => 'required|min:7|regex:/[a-zA-Z]/|regex:/[0-9]/',
            ]);

            $user = $request->user();

            if (!Hash::check($request->currentPassword, $user->password)) {
                return response()->json(['message' => 'Current password is incorrect'], 401);
            }

            $user->password = Hash::make($request->newPassword);
            $user->save();

            return response()->json(['message' => 'Password changed successfully!']);
        }

        public function getAddresses(Request $request)
        {
            $user = $request->user();
            return response()->json([
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'address1' => $user->address1,
                'city' => $user->city,
                'state' => $user->state,
                'zip' => $user->zip,
                'country' => $user->country,
                'phone' => $user->phone,
            ]);
        }

        public function updateAddress(Request $request)
        {
            $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'address1' => 'required|string',
                'city' => 'required|string',
                'state' => 'required|string',
                'zip' => 'required|string',
                'country' => 'required|string',
                'phone' => 'required|string',
            ]);

            $user = $request->user();
            $user->update($request->only([
                'first_name',
                'last_name',
                'address1',
                'city',
                'state',
                'zip',
                'country',
                'phone',
            ]));

            return response()->json(['message' => 'Address updated successfully!']);
        }


}