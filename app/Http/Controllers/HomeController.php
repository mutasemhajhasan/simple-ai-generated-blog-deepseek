<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPosts = Post::with('user')
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->take(3)
            ->get();

        $recentPosts = Post::with('user')
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->skip(3)
            ->take(6)
            ->get();

        $categories = Category::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->take(8)
            ->get();

        return view('home', compact('featuredPosts', 'recentPosts', 'categories'));
    }
}
