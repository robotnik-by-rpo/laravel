<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Artist extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'country', 'bio'];

    public function tracks(): HasMany
    {
        return $this->hasMany(Track::class);
    }

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }

    public function scopeFromCountry($query, string $country)
    {
        return $query->where('country', $country);
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where('name', 'ILIKE', "%{$term}%");
    }
}