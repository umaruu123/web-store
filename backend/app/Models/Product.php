<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'description',
        'image_url',
        'stock',
        'category_id',
        'status',
        'sku',
    ];

    protected $casts = [
        'status' => 'string', // 確保 status 是字符串類型
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
