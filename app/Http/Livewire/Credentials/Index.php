<?php

namespace App\Http\Livewire\Credentials;

use Livewire\Component;

class Index extends Component
{
    protected $listeners = [
        'refreshCredentials' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.credentials.index', [
            'items' => auth()->user()->currentTeam->credentials()
                ->orderBy('service', 'asc')
                ->get(),
        ]);
    }
}
