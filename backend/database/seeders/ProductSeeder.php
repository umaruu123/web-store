<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Cute Bunny Plush',
            'price' => 29.99,
            'description' => 'A soft and cuddly bunny plush.',
            'image_url' => 'https://example.com/bunny.jpg',
            'stock' => 10,
        ]);

        Product::create([
            'name' => 'Teddy Bear',
            'price' => 35.50,
            'description' => 'A fluffy teddy bear with a cute bow.',
            'image_url' => 'https://example.com/teddy.jpg',
            'stock' => 5,
        ]);
    }
}
