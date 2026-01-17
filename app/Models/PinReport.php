<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PinReport extends Model
{
    protected $fillable = [
        'pin_id',
        'user_id',
        'reason',
        'status',
    ];

    public function pin(): BelongsTo
    {
        return $this->belongsTo(PinPostgres::class, 'pin_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
