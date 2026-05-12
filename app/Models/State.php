<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class State extends Model implements HasMedia
{
    use HasSlug, InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'capital',
        'region',
        'language',
        'description',
        'established_date',
        'population',
        'area_sq_km',
        'cover_image',
        'is_active',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function culture(): HasOne
    {
        return $this->hasOne(StateCulture::class);
    }

    public function foods(): HasMany
    {
        return $this->hasMany(StateFood::class);
    }

    public function traditions(): HasMany
    {
        return $this->hasMany(StateTradition::class);
    }

    public function monuments(): HasMany
    {
        return $this->hasMany(Monument::class);
    }

    public function festivals(): HasMany
    {
        return $this->hasMany(Festival::class);
    }

    public function allFestivals(): BelongsToMany
    {
        return $this->belongsToMany(Festival::class, 'festival_states')
            ->withPivot('local_name', 'local_significance')
            ->withTimestamps();
    }
}
