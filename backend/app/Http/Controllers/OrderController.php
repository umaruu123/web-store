<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

class OrderController extends Controller
{
    // 創建訂單
    public function createOrder(Request $request)
    {
        $user = Auth::user();

        // 獲取購物車數據
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        // 檢查庫存
        foreach ($cartItems as $cartItem) {
            if ($cartItem->product->stock < $cartItem->quantity) {
                return response()->json(['message' => 'Insufficient stock for product: ' . $cartItem->product->name], 400);
            }
        }

        // 計算總金額
        $totalAmount = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // 創建訂單
        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);

        // 添加訂單商品並更新庫存
        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
            ]);

            // 更新庫存
            $cartItem->product->stock -= $cartItem->quantity;
            $cartItem->product->save();
        }

        // 清空購物車
        Cart::where('user_id', $user->id)->delete();

        // 發送訂單確認郵件
        Mail::to($user->email)->send(new OrderConfirmation($order));

        return response()->json(['message' => 'Order created successfully!', 'order' => $order], 201);
    }

    public function getOrders(Request $request)
    {
        $user = $request->user();

        // 獲取當前用戶的所有訂單
        $orders = Order::where('user_id', $user->id)
            ->with('items.product') // 加載訂單商品及其關聯的產品
            ->get();

        // 格式化訂單數據
        $formattedOrders = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'created_at' => $order->created_at,
                'total_amount' => $order->total_amount,
                'status' => $order->status,
                'items' => $order->items->map(function ($item) {
                    return [
                        'product_name' => $item->product->name,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                    ];
                }),
            ];
        });

        return response()->json($formattedOrders);
    }
}