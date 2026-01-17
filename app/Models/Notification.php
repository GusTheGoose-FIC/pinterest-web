<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'actor_id',
        'pin_id',
        'type',
        'message',
        'read',
    ];

    protected $casts = [
        'read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con el usuario que recibe la notificación
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con el usuario que realizó la acción
     */
    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    /**
     * Relación con el pin
     */
    public function pin()
    {
        return $this->belongsTo(PinPostgres::class);
    }

    /**
     * Marcar como leído
     */
    public function markAsRead()
    {
        $this->update(['read' => true]);
    }
}
