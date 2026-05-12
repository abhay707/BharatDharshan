<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Monument extends Model implements HasMedia
{
    use HasSlug, InteractsWithMedia;

    protected $fillable = [
        'state_id',
        'name',
        'slug',
        'short_description',
        'full_description',
        'type',
        'category',
        'built_by',
        'built_in_year',
        'dynasty_or_period',
        'entry_fee_indian',
        'entry_fee_foreign',
        'best_time_to_visit',
        'visiting_hours',
        'latitude',
        'longitude',
        'address',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'is_featured'       => 'boolean',
        'is_active'         => 'boolean',
        'entry_fee_indian'  => 'decimal:2',
        'entry_fee_foreign' => 'decimal:2',
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

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeByType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    public function scopeByCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function highlights(): HasMany
    {
        return $this->hasMany(MonumentHighlight::class);
    }

    public function tips(): HasMany
    {
        return $this->hasMany(MonumentTip::class);
    }
}
