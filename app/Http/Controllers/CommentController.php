<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'body' => 'required|min:5',
        ]);

        $comment = new Comment($validated);
        $comment->user_id = auth()->id();
        $comment->post_id = $post->id;

        if (auth()->user()?->isAdmin()) {
            $comment->approved_at = now();
        }

        $comment->save();

        return back()->with('success', 'Comment submitted!');
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'body' => 'required|min:5',
        ]);

        $comment->update($validated);

        return back()->with('success', 'Comment updated!');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return back()->with('success', 'Comment deleted!');
    }

    public function approve(Comment $comment)
    {
        $this->authorize('approve', Comment::class);
        $comment->update(['approved_at' => now()]);
        return back()->with('success', 'Comment approved!');
    }
}
