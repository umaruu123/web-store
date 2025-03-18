<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    // 定義與 Product 模型的關聯
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}