<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Category::class);
        $categories = Category::withCount('posts')->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $this->authorize('create', Category::class);
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Category::class);
        // Validation and store logic
    }

    public function show(Category $category)
    {
        // Eager load posts with their author and only published posts
        $posts = $category
            ->posts()
            ->with('user') // Load author info
            ->whereNotNull('published_at') // Only published posts
            ->latest('published_at') // Newest first
            ->paginate(10); // 10 posts per page

        return view('categories.show', compact('category', 'posts'));
    }

    public function edit(Category $category)
    {
        $this->authorize('update', $category);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->authorize('update', $category);
        // Validation and update logic
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);
        $category->delete();
        return redirect()->route('categories.index');
    }
}
