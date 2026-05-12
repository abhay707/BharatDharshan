<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class StateFood extends Model implements HasMedia
{
    use HasSlug, InteractsWithMedia;

    protected $table = 'state_foods';

    protected $fillable = [
        'state_id',
        'name',
        'slug',
        'description',
        'ingredients',
        'is_vegetarian',
        'meal_type',
        'origin_story',
        'image',
    ];

    protected $casts = [
        'is_vegetarian' => 'boolean',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
}
