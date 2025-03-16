<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    // 獲取所有用戶
    public function getAllUsers(Request $request)
    {
        // 確保只有管理員可以訪問這個方法
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // 獲取所有用戶
        $users = User::all();

        // 返回用戶數據
        return response()->json($users);
    }

    // 更新用戶資料（管理員專用）
    public function updateUserByAdmin(Request $request, $userId)
    {
        // 確保只有管理員可以訪問這個方法
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // 驗證請求資料
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'role' => 'required|in:user,admin',
            'phone' => 'required|string',
            'address1' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip' => 'required|string',
            'country' => 'required|string',
        ]);

        // 找到要更新的用戶
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // 更新用戶資料
        $user->update($request->only([
            'first_name',
            'last_name',
            'email',
            'role',
            'phone',
            'address1',
            'city',
            'state',
            'zip',
            'country',
        ]));

        return response()->json(['message' => 'User updated successfully!']);
    }

    // 刪除用戶（管理員專用）
    public function deleteUserByAdmin(Request $request, $userId)
    {
        // 確保只有管理員可以訪問這個方法
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // 找到要刪除的用戶
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // 刪除用戶
        $user->delete();

        return response()->json(['message' => 'User deleted successfully!']);
    }
    public function addUser(Request $request)
        {
            // 驗證請求資料
            $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:7|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/', // 密碼驗證
                'role' => 'required|in:user,admin',
                'phone' => 'required|string',
                'address1' => 'required|string',
                'city' => 'required|string',
                'state' => 'required|string',
                'zip' => 'required|string',
                'country' => 'required|string',
            ]);

            // 創建用戶
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => bcrypt($request->password), // 加密密碼
                'role' => $request->role,
                'phone' => $request->phone,
                'address1' => $request->address1,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
                'country' => $request->country,
            ]);

            return response()->json(['message' => 'User added successfully!', 'data' => $user], 201);
        }
}