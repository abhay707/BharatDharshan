<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FestivalTip extends Model
{
    protected $fillable = [
        'festival_id',
        'tip_category',
        'tip_title',
        'tip_body',
    ];

    public function festival(): BelongsTo
    {
        return $this->belongsTo(Festival::class);
    }
}
