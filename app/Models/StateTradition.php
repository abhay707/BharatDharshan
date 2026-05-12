<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class StateTradition extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'state_id',
        'name',
        'category',
        'description',
        'significance',
        'region_specific',
        'image',
    ];

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
}
