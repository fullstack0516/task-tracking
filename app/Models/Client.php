<?php

namespace App\Models;

use App\Traits\HasBadge;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory,
        SoftDeletes,
        HasBadge;

    protected $guarded = [];

    public function timeEntries(): HasMany
    {
        return $this->hasMany(TimeEntry::class);
    }

    public function retainers(): HasMany
    {
        return $this->hasMany(Retainer::class);
    }

    public function getInitialsIdentifier(): string
    {
        return $this->company;
    }
}
