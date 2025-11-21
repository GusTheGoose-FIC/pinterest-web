<?php

namespace App\Models;

<<<<<<< HEAD
use Mongodb\Eloquent\Model as Eloquent;
=======
use Illuminate\Database\Eloquent\Model;
use Mongodb\Eloquent\Model as Eloquent;

>>>>>>> PanelAdmin

class Image extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'images';

    protected $fillable = [
        'url',        // URL pública de la imagen
        'title',      // Título opcional
        'width',      // Ancho opcional para optimizar layout
        'height',     // Alto opcional
        'user_id',    // Referencia al usuario (opcional)
        'idea_id',    // Referencia a idea/tablero (opcional)
        'tags',       // array de tags
    ];

    protected $casts = [
        'tags' => 'array',
    ];
}
