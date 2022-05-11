<?php

namespace App\Http\Livewire\Dashboard;

use Illuminate\Support\Collection;
use Livewire\Component;

class Calendar extends Component
{
    public $currentDate;

    public Collection $events;

    public Collection $upcomingEvents;

    protected $listeners = [
        'refreshEvents',
    ];

    public function mount()
    {
        $this->currentDate = now();
        $this->refreshEvents();
    }

    public function refreshEvents()
    {
        $this->events = $this->getEvents();
        $this->upcomingEvents = $this->getUpcomingEvents();
    }

    public function getEvents()
    {
        return auth()->user()->currentTeam->events()
            ->where('starts_at', '<=', $this->currentDate->copy()->endOfDay())
            ->where('ends_at', '>=', $this->currentDate->copy()->startOfDay())
            ->orderBy('starts_at', 'asc')
            ->get();
    }

    public function getUpcomingEvents()
    {
        return auth()->user()->currentTeam->events()
            ->where('starts_at', '>=', now()->endOfDay())
            ->orderBy('starts_at', 'asc')
            ->take(5)
            ->get();
    }

    public function moveCalendarLeft()
    {
        $this->currentDate = $this->currentDate->subDay();
        $this->events = $this->getEvents();
    }

    public function moveCalendarRight()
    {
        $this->currentDate = $this->currentDate->addDay();
        $this->events = $this->getEvents();
    }

    public function render()
    {
        return view('livewire.dashboard.calendar');
    }
}
