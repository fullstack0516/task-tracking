<?php

namespace App\Http\Livewire\Projects;

use Livewire\Component;

class Index extends Component
{
    protected $listeners = [
        'refreshProjects' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.projects.index', [
            'items' => auth()->user()->currentTeam->projects()
                ->orderBy('updated_at', 'desc')
                ->get(),
        ]);
    }
}
