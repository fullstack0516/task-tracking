<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Task extends Model
{
    use HasFactory,
        SoftDeletes,
        LogsActivity;

    protected $guarded = [];

    protected static function booted()
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('position', 'asc');
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'priority', 'task_group_id', 'parent_task_id', 'type', 'priority'])
            ->logOnlyDirty();
    }

    public function getProjectAttribute()
    {
        return $this->taskGroup->project;
    }

    public function getTasksCompleteAttribute()
    {
        return $this->tasks()
            ->whereRelation('taskGroup', 'name', 'Done')
            ->count();
    }

    public function taskGroup(): BelongsTo
    {
        return $this->belongsTo(TaskGroup::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(self::class, 'parent_task_id', 'id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(TaskAttachment::class);
    }

    public function assignees(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
