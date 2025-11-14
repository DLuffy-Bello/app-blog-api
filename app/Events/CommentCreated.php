<?php

namespace App\Events;

use App\Models\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CommentCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Comment $comment;

    /**
     * Create a new event instance.
     */
    public function __construct(Comment $comm)
    {
        $this->comment = $comm;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('comments.' . $this->comment->post_id),
        ];
    }

    /**
     *
     */
    public function broadcastAs(): string
    {
        return 'comment.created';
    }

    /**
     *
     */
    public function broadcastWith(): array
    {
        Log::info('Push comment', [$this->comment->user->id]);
        return [
            'id' => $this->comment->id,
            'comment' => $this->comment->comment,
            'user_id' => $this->comment->user_id,
            'post_id' => $this->comment->post_id,
            'user' => [
                'id' => $this->comment->user->id,
                'name' => $this->comment->user->name
            ]
        ];
    }
}
