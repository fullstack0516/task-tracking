<?php

namespace App\Http\Livewire\Crm\Prospects;

use Livewire\Component;

class Index extends Component
{
    protected $listeners = [
        'refreshProspects' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.crm.prospects.index', [
            'items' => auth()->user()->currentTeam->prospects,
        ]);
    }
}
