<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

class CommentService
{
    public function createComment (array $data): bool
    {
        $saved = Comment::create($data);
        return (bool) $saved;
    }

    public function getAllComments(string $postId): Collection
    {
        $comments = Comment::where('post_id', $postId)->get();
        return $comments;
    }
}
