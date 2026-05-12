<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StateCulture extends Model
{
    protected $fillable = [
        'state_id',
        'classical_dance',
        'music_forms',
        'traditional_dress_male',
        'traditional_dress_female',
        'art_forms',
        'handicrafts',
        'language_script',
        'notable_personalities',
    ];

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
}
