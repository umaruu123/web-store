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

    // 獲取用戶訂單列表
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
                'created_at' => $order->created_at ? $order->created_at->toDateTimeString() : 'N/A',
                'total_amount' => $order->total_amount ?? 0,
                'status' => $order->status ?? 'Unknown Status',
                'items' => $order->items->map(function ($item) {
                    return [
                        'product_name' => $item->product ? $item->product->name : 'Unknown Product',
                        'quantity' => $item->quantity ?? 0,
                        'price' => $item->price ?? 0,
                    ];
                }),
            ];
        });

        return response()->json($formattedOrders);
    }

    // 獲取用戶訂單詳情
    public function getOrderDetails($orderId)
    {
        $user = Auth::user();

        // 獲取訂單詳情，並加載 items 和 items.product
        $order = Order::where('id', $orderId)
            ->where('user_id', $user->id)
            ->with('items.product')
            ->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // 格式化訂單數據
        $formattedOrder = [
            'id' => $order->id,
            'created_at' => $order->created_at ? $order->created_at->toDateTimeString() : 'N/A',
            'total_amount' => $order->total_amount ?? 0,
            'status' => $order->status ?? 'Unknown Status',
            'items' => $order->items->map(function ($item) {
                return [
                    'product_name' => $item->product ? $item->product->name : 'Unknown Product',
                    'quantity' => $item->quantity ?? 0,
                    'price' => $item->price ?? 0,
                ];
            }),
        ];

        return response()->json($formattedOrder);
    }

    // 取消訂單
    public function cancelOrder($orderId)
    {
        $user = Auth::user();

        // 獲取訂單
        $order = Order::where('id', $orderId)
            ->where('user_id', $user->id)
            ->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // 取消訂單
        $order->status = 'cancelled';
        $order->save();

        return response()->json(['message' => 'Order cancelled successfully']);
    }

    // 獲取所有訂單（管理員用）
    public function getAdminOrders(Request $request)
    {
        $orders = Order::with(['user', 'items.product'])
            ->get();

        $formattedOrders = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'customer' => $order->user ? $order->user->first_name . ' ' . $order->user->last_name : 'Unknown Customer',
                'date' => $order->created_at ? $order->created_at->toDateTimeString() : 'N/A',
                'total' => $order->total_amount ?? 0,
                'status' => $order->status ?? 'Unknown Status',
                'items' => $order->items->map(function ($item) {
                    return [
                        'product_name' => $item->product ? $item->product->name : 'Unknown Product',
                        'quantity' => $item->quantity ?? 0,
                        'price' => $item->price ?? 0,
                    ];
                }),
            ];
        });

        return response()->json($formattedOrders);
    }

    // 獲取訂單詳情（管理員用）
    public function getAdminOrderDetails($orderId)
    {
        $order = Order::with(['user', 'items.product'])->find($orderId);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $formattedOrder = [
            'id' => $order->id,
            'customer' => $order->user ? $order->user->first_name . ' ' . $order->user->last_name : 'Unknown Customer',
            'date' => $order->created_at ? $order->created_at->toDateTimeString() : 'N/A',
            'total' => $order->total_amount ?? 0,
            'status' => $order->status ?? 'Unknown Status',
            'items' => $order->items->map(function ($item) {
                return [
                    'product_name' => $item->product ? $item->product->name : 'Unknown Product',
                    'quantity' => $item->quantity ?? 0,
                    'price' => $item->price ?? 0,
                ];
            }),
        ];

        return response()->json($formattedOrder);
    }

    // 更新訂單狀態（管理員用）
    public function updateOrderStatus(Request $request, $orderId)
    {
        try {
            // 查找訂單
            $order = Order::find($orderId);

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            // 驗證狀態值
            $status = $request->input('status');
            $allowedStatuses = ['pending', 'completed', 'cancelled', 'shipped', 'delivered'];

            if (!in_array($status, $allowedStatuses)) {
                return response()->json(['message' => 'Invalid status'], 400);
            }

            // 更新訂單狀態
            $order->status = $status;
            $order->save();

            return response()->json(['message' => 'Order status updated successfully']);
        } catch (\Exception $e) {
            // 捕獲異常並返回錯誤信息
            return response()->json(['message' => 'Failed to update order status', 'error' => $e->getMessage()], 500);
        }
    }
}