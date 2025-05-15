<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    public function definition()
    {
        $title = $this->faker->sentence(rand(3, 8));

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => $this->faker->paragraph(rand(1, 2)),
            'body' => collect($this->faker->paragraphs(rand(5, 15)))
                        ->map(fn($p) => "<p>$p</p>")
                        ->implode(''),
            'featured_image' => rand(0, 1) ? 'featured-images/'.rand(1,10).'.jpg' : null,
        ];
    }
}
