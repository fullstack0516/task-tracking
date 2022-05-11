<?php

namespace App\Http\Livewire\Dashboard;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class Feed extends Component
{
    public Collection $items;

    public int $page = 0;

    public int $totalPages = 0;

    public function mount()
    {
        $this->items = $this->getItems();
        $this->totalPages = Activity::whereNotNull('causer_type')->count() / 10;
    }

    public function getItems()
    {
        return Activity::whereNotNull('causer_type')
            ->latest()
            ->take(10)
            ->offset($this->page * 10)
            ->get();
    }

    public function loadMore()
    {
        $this->page++;

        $this->items = $this->items->merge(
            $this->getItems()
        );
    }

    public function render()
    {
        return view('livewire.dashboard.feed');
    }
}
