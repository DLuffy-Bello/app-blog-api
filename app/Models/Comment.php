<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Comment extends Model
{
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $filltable = [
        'comment',
        'user_id',
        'post_id',
    ];

    /**
     *
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
