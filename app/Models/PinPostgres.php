<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class PinPostgres extends Eloquent
{
    use HasFactory;

    protected $connection = 'pgsql';
    protected $table = 'pins';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image_url',
        'link',
        'board',
        'alt_text',
        'allow_comments',
        'show_similar',
        'mongo_id',
    ];

    protected $casts = [
        'allow_comments' => 'boolean',
        'show_similar' => 'boolean',
    ];

    /**
     * Relación con el usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Devuelve el documento de MongoDB asociado usando mongo_id.
     */
    public function mongo()
    {
        if (!$this->mongo_id) return null;
        return Pin::find($this->mongo_id);
    }

    /**
     * Accesor: si no hay image_url en Postgres, la toma desde Mongo.
     */
    public function getImageUrlAttribute($value)
    {
        if (!empty($value)) return $value;
        $mongo = $this->mongo();
        return $mongo->image_url ?? null;
    }

    /**
     * Accesores opcionales para coherencia de datos (fallback a Mongo).
     */
    public function getTitleAttribute($value)
    {
        if (!empty($value)) return $value;
        $mongo = $this->mongo();
        return $mongo->title ?? null;
    }

    public function getDescriptionAttribute($value)
    {
        if (!empty($value)) return $value;
        $mongo = $this->mongo();
        return $mongo->description ?? null;
    }

    public function getBoardAttribute($value)
    {
        if (!empty($value)) return $value;
        $mongo = $this->mongo();
        return $mongo->board ?? null;
    }

    public function getAltTextAttribute($value)
    {
        if (!empty($value)) return $value;
        $mongo = $this->mongo();
        return $mongo->alt_text ?? null;
    }

    public function getAllowCommentsAttribute($value)
    {
        if (!is_null($value)) return (bool) $value;
        $mongo = $this->mongo();
        return (bool) ($mongo->allow_comments ?? true);
    }

    public function getShowSimilarAttribute($value)
    {
        if (!is_null($value)) return (bool) $value;
        $mongo = $this->mongo();
        return (bool) ($mongo->show_similar ?? true);
    }

    public function getTagsAttribute($value)
    {
        if (!empty($value)) return is_array($value) ? $value : json_decode($value, true);
        $mongo = $this->mongo();
        return $mongo->tags ?? [];
    }

    public function getProductsAttribute($value)
    {
        if (!empty($value)) return is_array($value) ? $value : json_decode($value, true);
        $mongo = $this->mongo();
        return $mongo->products ?? [];
    }
}
