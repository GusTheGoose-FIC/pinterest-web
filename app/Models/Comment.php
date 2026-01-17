<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    protected $fillable = [
        'pin_id',
        'user_id',
        'parent_id',
        'content',
    ];

    /**
     * Get the pin that this comment belongs to.
     */
    public function pin(): BelongsTo
    {
        return $this->belongsTo(PinPostgres::class, 'pin_id');
    }

    /**
     * Get the user who wrote this comment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent comment if this is a reply.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Get all replies to this comment.
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')->orderBy('created_at', 'asc');
    }

    /**
     * Check if this comment is a reply.
     */
    public function isReply(): bool
    {
        return $this->parent_id !== null;
    }
}
