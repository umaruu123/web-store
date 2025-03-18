<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // 獲取用戶購物車
    public function getCart()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->with('product')->get();

        // 確保 price 是數字類型
        $cart->each(function ($item) {
            $item->product->price = (float) $item->product->price;
        });

        return response()->json($cart);
    }

    // 添加商品到購物車
    public function addToCart(Request $request)
    {
        $user = Auth::user();
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        // 檢查商品是否存在
        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // 檢查購物車中是否已經有該商品
        $cartItem = Cart::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            // 如果商品已存在，增加數量
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // 否則創建新的購物車項目
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return response()->json(['message' => 'Product added to cart']);
    }

    // 從購物車中移除商品
    public function removeFromCart($productId)
    {
        $user = Auth::user();
        Cart::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->delete();

        return response()->json(['message' => 'Product removed from cart']);
    }

    // 清空購物車
    public function clearCart()
    {
        $user = Auth::user();
        Cart::where('user_id', $user->id)->delete();
        return response()->json(['message' => 'Cart cleared']);
    }
}