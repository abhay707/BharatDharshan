<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FestivalRitual extends Model
{
    protected $fillable = [
        'festival_id',
        'ritual_name',
        'ritual_description',
        'ritual_timing',
    ];

    protected $casts = [
        'ritual_timing' => 'string',
    ];

    public function festival(): BelongsTo
    {
        return $this->belongsTo(Festival::class);
    }
}
