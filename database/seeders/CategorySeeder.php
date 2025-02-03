<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'image' => null,
                'parent_id' => null,
                'is_active' => 1,
            ],
            [
                'name' => 'Mobile',
                'image' => null,
                'parent_id' => 1,
                'is_active' => 1,
            ],
            [
                'name' => 'Laptop',
                'image' => null,
                'parent_id' => 1,
                'is_active' => 1,
            ],
            [
                'name' => 'Clothing',
                'image' => null,
                'parent_id' => null,
                'is_active' => 1,
            ]
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
