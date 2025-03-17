<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $products = Product::with('category')->get(); // 加載關聯的類別
        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 通常用於返回視圖（例如新增產品的表單）
        // 如果是 API，則不需要此方法
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id', // 確保類別存在
            'sku' => 'required|string|unique:products,sku',
            'status' => 'required|in:active,inactive,out_of_stock',
            'image_url' => 'nullable|url',
            'description' => 'nullable|string',
        ]);

        $product = Product::create($validatedData);
        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): JsonResponse
    {
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // 通常用於返回視圖（例如編輯產品的表單）
        // 如果是 API，則不需要此方法
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric',
            'stock' => 'sometimes|integer',
            'category_id' => 'sometimes|exists:categories,id', // 確保類別存在
            'sku' => 'sometimes|string|unique:products,sku,' . $product->id,
            'status' => 'sometimes|in:active,inactive,out_of_stock',
            'image_url' => 'nullable|url',
            'description' => 'nullable|string',
        ]);

        $product->update($validatedData);
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): JsonResponse
    {
        // 刪除產品
        $product->delete();

        return response()->json(null, 204); // 204 表示資源刪除成功
    }
    public function getProductsByCategory($categoryName): JsonResponse
    {
        $products = Product::whereHas('category', function ($query) use ($categoryName) {
            $query->where('name', $categoryName);
        })->get();

        return response()->json($products);
    }
}