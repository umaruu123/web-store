<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class WishlistController extends Controller
{
    // 獲取當前用戶的願望清單
    public function getWishlist()
    {
        $user = Auth::user();
        $wishlist = Wishlist::where('user_id', $user->id)
            ->with('product') // 加載關聯的產品
            ->get();

        return response()->json($wishlist);
    }

    // 添加商品到願望清單
    public function addToWishlist(Request $request)
    {
        $user = Auth::user();
        $productId = $request->input('itemId');

        // 獲取商品詳情
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // 檢查是否已經存在於願望清單
        $existing = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            return response()->json(['message' => 'Product already in wishlist'], 400);
        }

        // 添加到願望清單
        $wishlist = Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $productId,
        ]);

        return response()->json($wishlist, 201);
    }

    // 從願望清單中移除商品
    public function removeFromWishlist($itemId)
    {
        $user = Auth::user();
        $wishlist = Wishlist::where('user_id', $user->id)
            ->where('id', $itemId)
            ->first();

        if (!$wishlist) {
            return response()->json(['message' => 'Item not found in wishlist'], 404);
        }

        $wishlist->delete();
        return response()->json(['message' => 'Item removed from wishlist']);
    }
}