<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Pin;
use Illuminate\Support\Str;

class PinPostgres extends Model
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
     * Relación con comentarios
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'pin_id')->orderBy('created_at', 'desc');
    }

    /**
     * Relación con likes
     */
    public function likes()
    {
        return $this->hasMany(Like::class, 'pin_id');
    }

    /**
     * Relación con guardados.
     */
    public function savedPins()
    {
        return $this->hasMany(SavedPin::class, 'pin_id');
    }

    /**
     * Relación con reportes
     */
    public function reports()
    {
        return $this->hasMany(PinReport::class, 'pin_id');
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
        $resolved = $value;
        if (empty($resolved)) {
            $mongo = $this->mongo();
            $resolved = $mongo->image_url ?? null;
        }

        return $this->normalizeImageUrlForWeb($resolved);
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

    private function normalizeImageUrlForWeb($url)
    {
        $value = trim((string) ($url ?? ''));
        if ($value === '') {
            return null;
        }

        if (!app()->bound('request')) {
            return $value;
        }

        $base = request()->getSchemeAndHttpHost();

        if (Str::startsWith($value, '/')) {
            return rtrim($base, '/') . $value;
        }

        $parsed = parse_url($value);
        $host = strtolower((string) ($parsed['host'] ?? ''));

        if (in_array($host, ['localhost', '127.0.0.1', '10.0.2.2', '0.0.0.0'], true)) {
            $path = (string) ($parsed['path'] ?? '');
            if ($path === '') {
                return $value;
            }

            $query = isset($parsed['query']) ? ('?' . $parsed['query']) : '';
            $fragment = isset($parsed['fragment']) ? ('#' . $parsed['fragment']) : '';

            return rtrim($base, '/') . $path . $query . $fragment;
        }

        return $value;
    }
}
