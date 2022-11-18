<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property mixed id
 * @property mixed user_id
 * @property mixed destination
 * @property mixed slug
 * @property integer views
 * @property Carbon updated_at
 * @property Carbon created_at
 * @property mixed shortened_url
 */
class Url extends Model
{
    use HasFactory;

    protected $fillable = [
        'destination', 'slug', 'views', 'user_id'
    ];

    protected $appends = [
        'shortened_url'
    ];

    public function ShortenedUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => url($this->attributes['slug']),
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function newSlug(int $length = 5): string
    {
        return substr(str_shuffle(MD5(microtime())), 0, $length);
    }
}
