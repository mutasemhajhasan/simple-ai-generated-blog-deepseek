<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Technology',
            'Programming',
            'Web Development',
            'Mobile Development',
            'Design',
            'Business',
            'Marketing',
            'Science',
            'Health',
            'Travel'
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => \Illuminate\Support\Str::slug($category),
                'description' => 'Articles about ' . $category,
            ]);
        }
    }
}
