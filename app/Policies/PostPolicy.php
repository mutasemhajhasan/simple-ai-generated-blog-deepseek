<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Post $post): bool
    {
        return $post->isPublished() || $user->is($post->user);
    }

    public function create(User $user): bool
    {
        return $user->exists;
    }

    public function update(User $user, Post $post): bool
    {
        return $user->is($post->user) || $user->isAdmin();
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->is($post->user) || $user->isAdmin();
    }

    public function restore(User $user, Post $post): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Post $post): bool
    {
        return $user->isAdmin();
    }

    public function publish(User $user, Post $post): bool
    {
        return $user->is($post->user);
    }
}
