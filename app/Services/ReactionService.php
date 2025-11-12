<?php

namespace App\Services;

use App\Models\Reaction;

class ReactionService
{
    /**
     * Toggle like reaction for a post by a user.
     *
     * @param array $data
     * @param string $userId
     * @return bool
     */
    public function toggleLike(array $data, string $userId): bool
    {
        $findReaction = Reaction::where('post_id', $data['post_id'])
            ->where('user_id', $userId)
            ->where('type', $data['type'])
            ->first();
        if ($findReaction) {
            $findReaction->delete();
            return false;
        }
        $create = Reaction::create([
            'post_id' => $data['post_id'],
            'user_id' => $userId,
            'type' => $data['type'],
        ]);
        return (bool) $create;
    }
}
