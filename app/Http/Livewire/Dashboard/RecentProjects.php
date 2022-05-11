<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class RecentProjects extends Component
{
    public function getRecentProjects()
    {
        return auth()->user()->currentTeam->projects()->latest()->take(8)->get();
    }

    public function render()
    {
        return view('livewire.dashboard.recent-projects', [
            'projects' => $this->getRecentProjects(),
        ]);
    }
}
