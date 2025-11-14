<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class CommentService
{
    public function createComment (array $data): Comment
    {
        $saved = Comment::create($data);
        $saved->load('user:id,name');
        return $saved;
    }


    public function getAllComments(string $postId): Collection
    {
        $comments = Comment::with(['user:id,name'])->where('post_id', $postId)->get();
        return $comments;
    }
}
