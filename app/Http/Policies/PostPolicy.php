<?php

namespace App\Http\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function update(User $user, Post $post): bool
    {
        return $post->user_id === $user->getKey();
    }

    public function delete(User $user, Post $post): bool
    {
        return $post->user_id === $user->getKey();
    }
}
