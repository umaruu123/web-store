<?php

// app/Models/Category.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    // 定義與 Product 模型的關聯
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}