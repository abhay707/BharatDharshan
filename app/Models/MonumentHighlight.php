<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonumentHighlight extends Model
{
    protected $fillable = [
        'monument_id',
        'highlight',
    ];

    public function monument(): BelongsTo
    {
        return $this->belongsTo(Monument::class);
    }
}
