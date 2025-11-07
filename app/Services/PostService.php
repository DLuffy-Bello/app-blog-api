<?php

namespace App\Services;

use App\Models\Post;

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
}
