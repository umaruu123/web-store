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
        Schema::table('users', function (Blueprint $table) {
            // 移除 name 欄位
            $table->dropColumn('name'); 

            // 添加新的使用者欄位
            $table->string('first_name')->after('email');
            $table->string('last_name')->after('first_name');
            $table->enum('gender', ['male', 'female', 'other'])->after('last_name');
            $table->string('address1')->after('gender');
            $table->string('address2')->nullable()->after('address1');
            $table->string('city')->after('address2');
            $table->string('state')->after('city');
            $table->string('zip')->after('state');
            $table->string('country')->after('zip');
            $table->string('phone')->after('country');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 還原 name 欄位
            $table->string('name')->after('id');

            // 刪除新的使用者欄位
            $table->dropColumn([
                'first_name', 'last_name', 'gender', 'address1', 'address2', 
                'city', 'state', 'zip', 'country', 'phone'
            ]);
        });
    }
};
