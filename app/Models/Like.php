<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    protected $fillable = [
        'pin_id',
        'user_id',
    ];

    /**
     * Get the pin that this like belongs to.
     */
    public function pin(): BelongsTo
    {
        return $this->belongsTo(PinPostgres::class, 'pin_id');
    }

    /**
     * Get the user who liked this pin.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
