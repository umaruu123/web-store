<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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

        return response()->json(['message' => 'User registered successfully!'], 201);
    }
}
