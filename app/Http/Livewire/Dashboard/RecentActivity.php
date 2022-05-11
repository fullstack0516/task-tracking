<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class RecentActivity extends Component
{
    public function getActivityLogs()
    {
        return Activity::latest()->take(5)->get();
    }

    public function render()
    {
        return view('livewire.dashboard.recent-activity', [
            'logs' => $this->getActivityLogs(),
        ]);
    }
}
