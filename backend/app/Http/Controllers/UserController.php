<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountVerification;
use Illuminate\Support\Str;
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

        // 生成驗證令牌
        $verificationToken = Str::random(60);

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
            'verification_token' => $verificationToken,
            'verification_expires_at' => Carbon::now()->addHours(24),
        ]);

        // 發送驗證郵件
        Mail::to($user->email)->send(new AccountVerification($user));

        return response()->json(['message' => 'User registered successfully! Please check your email to verify your account.'], 201);
    }

    public function verifyAccount($token)
{
    $user = User::where('verification_token', $token)
                ->where('verification_expires_at', '>', Carbon::now())
                ->first();

    if (!$user) {
        return response()->json(['message' => 'Invalid or expired verification token.'], 400);
    }

    $user->email_verified_at = Carbon::now();
    $user->verification_token = null;
    $user->verification_expires_at = null;
    $user->save();

    return redirect()->away(env('FRONTEND_URL') . '/login?verified=1');
}
}