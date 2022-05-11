<?php

namespace App\Http\Livewire\Crm\Dashboard;

use Livewire\Component;

class Stats extends Component
{
    public int $wins;

    public int $lost;

    public function mount()
    {
        $team = auth()->user()->currentTeam;
        $this->prospects = $team->prospects()->count();
        $this->wins = $team->clients()->count();
        $this->lost = $team->clients()->onlyTrashed()->count();
    }

    public function render()
    {
        return view('livewire.crm.dashboard.stats');
    }
}
