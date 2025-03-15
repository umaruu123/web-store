<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * 獲取所有類別
     */
    public function index(): JsonResponse
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    /**
     * 新增類別
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
        ]);

        $category = Category::create($validatedData);

        return response()->json([
            'message' => 'Category created successfully.',
            'data' => $category,
        ], 201); // 201 表示資源創建成功
    }

    /**
     * 刪除類別
     */
    public function destroy(Category $category): JsonResponse
    {
        // 檢查是否有產品關聯到該類別
        if ($category->products()->exists()) {
            return response()->json([
                'message' => 'Cannot delete category because it has associated products.',
            ], 422); // 422 表示請求無法處理
        }

        // 刪除類別
        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully.',
        ], 204); // 204 表示資源刪除成功
    }

    /**
     * 更新類別
     */
    public function update(Request $request, Category $category): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($validatedData);

        return response()->json([
            'message' => 'Category updated successfully.',
            'data' => $category,
        ]);
    }
}