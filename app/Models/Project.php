<?php

namespace App\Models;

use App\Traits\HasBadge;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Project extends Model
{
    use HasFactory,
        SoftDeletes,
        LogsActivity,
        HasBadge;

    protected $guarded = [];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function taskGroups(): HasMany
    {
        return $this->hasMany(TaskGroup::class);
    }

    public function tasks(): HasManyThrough
    {
        return $this->hasManyThrough(Task::class, TaskGroup::class);
    }

    public function outstandingTasks(): HasManyThrough
    {
        return $this->tasks()->whereNotIn('task_group_id', [
            $this->taskGroups()->whereName('Done')->first()->id,
        ]);
    }

    public function getInitialsIdentifier(): string
    {
        return $this->name;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'description', 'repository_url'])
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty();
    }
}
