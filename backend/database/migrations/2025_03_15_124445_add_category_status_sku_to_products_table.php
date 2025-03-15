<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
             // 檢查 status 欄位是否存在，如果不存在則新增
        if (!Schema::hasColumn('products', 'status')) {
            $table->enum('status', ['active', 'inactive', 'out_of_stock'])
                  ->default('active'); // 默認值為 active
        }

        // 檢查 sku 欄位是否存在，如果不存在則新增
        if (!Schema::hasColumn('products', 'sku')) {
            $table->string('sku')->unique(); // 確保 SKU 是唯一的
        }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
         // 檢查 status 欄位是否存在，如果存在則移除
        if (Schema::hasColumn('products', 'status')) {
            $table->dropColumn('status');
        }

        // 檢查 sku 欄位是否存在，如果存在則移除
        if (Schema::hasColumn('products', 'sku')) {
            $table->dropColumn('sku');
        }
        });
    }
};
