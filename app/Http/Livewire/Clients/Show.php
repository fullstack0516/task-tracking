<?php

namespace App\Http\Livewire\Clients;

use App\Models\Client;
use Livewire\Component;

class Show extends Component
{
    public Client $client;

    public $timeUsedForMonth;

    public $timeRemaining;

    public function mount()
    {
        $this->timeUsedForMonth = round($this->client->timeEntries()
            ->where('date', '>=', now()->copy()->startOfMonth())
            ->where('date', '<=', now()->copy()->endOfMonth())
            ->sum('hours') / 7, 2);

        $hoursUsed = $this->client->timeEntries()
            ->where('date', '>=', now()->copy()->startOfMonth())
            ->where('date', '<=', now()->copy()->endOfMonth())
            ->sum('hours') / 7;

        $this->timeRemaining = round($this->client->retainer - $hoursUsed, 2);
    }

    public function render()
    {
        return view('livewire.clients.show');
    }
}
