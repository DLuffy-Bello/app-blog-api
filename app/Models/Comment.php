<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'comment',
        'user_id',
        'post_id',
    ];

    /**
     *
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
