<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    public function run()
    {
        $posts = Post::all();
        $users = User::all();

        // Create 200 comments
        Comment::factory()->count(200)->make()->each(function ($comment) use ($posts, $users) {
            $comment->post_id = $posts->random()->id;
            $comment->user_id = $users->random()->id;

            // 80% chance of being approved
            $comment->approved_at = rand(0, 9) < 8 ? now() : null;

            $comment->save();
        });
    }
}
