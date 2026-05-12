<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Festival extends Model implements HasMedia
{
    use HasSlug, InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'tagline',
        'state_id',
        'is_national',
        'religion',
        'month',
        'start_day',
        'end_day',
        'duration_days',
        'short_description',
        'full_description',
        'significance',
        'how_celebrated',
        'cover_image',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'is_national' => 'boolean',
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getMonthNameAttribute(): string
    {
        return \DateTime::createFromFormat('!m', $this->month)->format('F');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeByMonth(Builder $query, int $month): Builder
    {
        return $query->where('month', $month);
    }

    public function scopeByReligion(Builder $query, string $religion): Builder
    {
        return $query->where('religion', $religion);
    }

    public function scopeNational(Builder $query): Builder
    {
        return $query->where('is_national', true);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function celebratingStates(): BelongsToMany
    {
        return $this->belongsToMany(State::class, 'festival_states')
            ->withPivot('local_name', 'local_significance')
            ->withTimestamps();
    }

    public function tips(): HasMany
    {
        return $this->hasMany(FestivalTip::class);
    }

    public function rituals(): HasMany
    {
        return $this->hasMany(FestivalRitual::class);
    }
}
