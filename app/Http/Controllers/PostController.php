<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user', 'categories')
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'excerpt' => 'required',
            'categories' => 'array',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $post = new Post($validated);
        $post->user_id = auth()->id();
        $post->published_at =Carbon::now();
        $post->slug = Str::slug($request->title);

        if ($request->hasFile('featured_image')) {
            $post->featured_image = $request->file('featured_image')->store('featured-images','public');
        }

        $post->save();

        if ($request->has('categories')) {
            $post->categories()->sync($request->categories);
        }

        return redirect()->route('posts.show', $post);
    }

    public function show(Post $post)
    {
        if (is_null($post->published_at) && !auth()->user()?->is($post->user)) {
            abort(404);
        }

        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'excerpt' => 'required',
            'categories' => 'array',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $post->fill($validated);
        $post->slug = Str::slug($request->title);

        if ($request->hasFile('featured_image')) {
            $post->featured_image = $request->file('featured_image')->store('featured-images');
        }

        $post->save();

        if ($request->has('categories')) {
            $post->categories()->sync($request->categories);
        }

        return redirect()->route('posts.show', $post);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect()->route('posts.index');
    }
}
