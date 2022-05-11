<?php

namespace App\Http\Livewire\Crm\Dashboard;

use Livewire\Component;

class Activity extends Component
{
    public function render()
    {
        return view('livewire.crm.dashboard.activity', [
            'items' => auth()->user()->currentTeam
                ->prospects()
                ->orderBy('updated_at', 'desc')
                ->take(10)
                ->get(),
        ]);
    }
}
