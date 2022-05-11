<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TaskAttachment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getUrlAttribute()
    {
        return Storage::disk('spaces')->temporaryUrl(
            $this->cloudname,
            now()->addMinutes(5)
        );
    }
}
