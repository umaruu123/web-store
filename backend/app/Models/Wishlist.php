<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
    ];

    // 關聯到 User 模型
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 關聯到 Product 模型
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}