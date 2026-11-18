<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Track extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['artist_id', 'album_id', 'title', 'year', 'duration'];

    protected $casts = [
        'year'     => 'integer',
        'duration' => 'integer',
    ];


    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'genre_track');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }


    public function scopeReleasedAfter($query, int $year)
    {
        return $query->where('year', '>=', $year);
    }

    public function scopeInGenre($query, string $slug)
    {
        return $query->whereHas('genres', fn ($q) => $q->where('slug', $slug));
    }

    public function scopeByArtist($query, int $artistId)
    {
        return $query->where('artist_id', $artistId);
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where('title', 'ILIKE', "%{$term}%");
    }
}