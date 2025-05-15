<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Comment $comment): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->exists;
    }

    public function update(User $user, Comment $comment): bool
    {
        return $user->is($comment->user) || $user->isAdmin();
    }

    public function delete(User $user, Comment $comment): bool
    {
        return $user->is($comment->user) || $user->isAdmin();
    }

    public function restore(User $user, Comment $comment): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Comment $comment): bool
    {
        return $user->isAdmin();
    }

    public function approve(User $user): bool
    {
        return $user->isAdmin();
    }
}
