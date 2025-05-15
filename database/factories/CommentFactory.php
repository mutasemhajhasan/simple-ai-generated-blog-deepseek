<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition()
    {
        return [
            'body' => $this->faker->paragraph(rand(1, 5)),
        ];
    }
}
