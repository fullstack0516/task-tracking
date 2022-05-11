<?php

namespace App\Http\Livewire\Clients;

use Livewire\Component;

class Index extends Component
{
    protected $listeners = [
        'refreshClients' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.clients.index', [
            'items' => auth()->user()->currentTeam->clients,
        ]);
    }
}
