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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
