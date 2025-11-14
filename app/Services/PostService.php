<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

class PostService
{
    /**
     * Create a new post.
     *
     * @param array $data
     * @return Post
     */
    public function createPost(array $data): Post
    {
        return Post::create($data);
    }

    /**
     * Get all posts.
     * @return Collection
     */
    public function getAllPosts(string $userId): Collection
    {
        $posts = Post::orderBy('created_at', 'asc')->get();
        return $posts->map(function (Post $post) use ($userId) {
            $post->liked_by_user = $post->isLikedByUser($userId);
            return $post;
        });
    }
}
