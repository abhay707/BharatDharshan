<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonumentTip extends Model
{
    protected $fillable = [
        'monument_id',
        'tip',
        'tip_type',
    ];

    public function monument(): BelongsTo
    {
        return $this->belongsTo(Monument::class);
    }
}
