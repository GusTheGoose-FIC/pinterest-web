<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use MongoDB\Laravel\Eloquent\Model as Eloquent;
use MongoDB\Laravel\Eloquent\Model;

class Pin extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'pins';

    protected $fillable = [
        'user_id',          // ID del usuario que creó el pin
        'title',            // Título del pin
        'description',      // Descripción detallada
        'image_url',        // URL de la imagen subida
        'link',             // Enlace opcional
        'board',            // Tablero seleccionado
        'tags',             // Temas etiquetados (array)
        'products',         // Productos etiquetados (array)
        'allow_comments',   // Permitir comentarios (boolean)
        'show_similar',     // Mostrar productos similares (boolean)
        'alt_text',         // Texto alternativo para accesibilidad
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'products' => 'array',
        'allow_comments' => 'boolean',
        'show_similar' => 'boolean',
    ];

    // Relación con el usuario (PostgreSQL)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
