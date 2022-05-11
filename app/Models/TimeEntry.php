<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TimeEntry extends Model
{
    use HasFactory,
        SoftDeletes,
        LogsActivity;

    protected $guarded = [];

    protected $casts = [
        'date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function retainer(): BelongsTo
    {
        return $this->belongsTo(Retainer::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['task', 'hours', 'note'])
            ->logOnlyDirty();
    }

    public function getDateAttribute($value)
    {
        return $value ? now()->parse($value)->format('Y-m-d') : null;
    }
}
