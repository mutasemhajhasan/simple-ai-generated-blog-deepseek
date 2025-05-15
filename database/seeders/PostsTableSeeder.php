<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PostsTableSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $categories = \App\Models\Category::all();

        // Create 50 blog posts
        Post::factory()->count(50)->make()->each(function ($post) use ($users, $categories) {
            $post->user_id = $users->random()->id;
            $post->published_at = Carbon::now()->subDays(rand(0, 30));
            $post->save();

            // Attach 1-3 random categories to each post
            $post->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
