<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Post extends Model
{
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'body',
        'user_id',
        'type',
        'url_image',
    ];

    /**
     *
     */
    public function isLikedByUser(string $userId): bool
    {
        return Reaction::where('post_id', $this->id)
            ->where('user_id', $userId)
            ->exists();
    }
}
