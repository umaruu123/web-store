<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'ANIMALS', 'slug' => 'animals', 'description' => 'Products related to animals'],
            ['name' => 'BAGS & CHAIRS', 'slug' => 'bags-chairs', 'description' => 'Products related to bags and chairs'],
            ['name' => 'BABY & BOOKS', 'slug' => 'baby-books', 'description' => 'Products related to baby and books'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
