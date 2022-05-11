<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProspectCommunication extends Model
{
    use HasFactory,
        SoftDeletes;

    protected $guarded = [];

    public function prospect(): BelongsTo
    {
        return $this->belongsTo(Prospect::class);
    }
}
