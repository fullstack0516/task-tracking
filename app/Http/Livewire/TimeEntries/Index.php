<?php

namespace App\Http\Livewire\TimeEntries;

use App\Exports\TimesheetExport;
use App\Models\Client;
use App\Models\TimeEntry;
use Illuminate\Support\Collection;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    public Collection $clients;

    public ?Client $client;

    public $currentDate;

    public $timeUsedLastMonth;

    public $timeUsedForMonth;

    public $timeRemaining;

    public $timeUsedToday;

    public function mount()
    {
        $this->clients = auth()->user()->currentTeam->clients;
        $this->client = auth()->user()->currentTeam->clients()->whereNotNull('retainer')->first();
        $this->currentDate = now();
    }

    public function export()
    {
        $entries = $this->getEntries();

        $data = $entries->map(function ($timeEntry) {
            return [
                $timeEntry->date,
                $timeEntry->hours,
                $timeEntry->task,
                $timeEntry->note,
            ];
        })->toArray();

        return Excel::download(new TimesheetExport($data), 'timesheet.xlsx');
    }

    public function getEntries()
    {
        return $this->client->timeEntries()
            ->whereBetween('date', [$this->currentDate->copy()->startOfMonth(), $this->currentDate->copy()->endOfMonth()])
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function prevMonth()
    {
        $this->currentDate = $this->currentDate->subMonth();
    }

    public function nextMonth()
    {
        $this->currentDate = $this->currentDate->addMonth();
    }

    public function getStats()
    {
        $this->timeUsedLastMonth = round($this->client->timeEntries()
            ->where('date', '>=', now()->copy()->subMonth()->startOfMonth())
            ->where('date', '<=', now()->copy()->subMonth()->endOfMonth())
            ->sum('hours') / 7, 2);

        $this->timeUsedForMonth = round($this->client->timeEntries()
            ->where('date', '>=', $this->currentDate->copy()->startOfMonth())
            ->where('date', '<=', $this->currentDate->copy()->endOfMonth())
            ->sum('hours') / 7, 2);

        $hoursUsedThisMonth = $this->client->timeEntries()
            ->where('date', '>=', $this->currentDate->copy()->startOfMonth())
            ->where('date', '<=', $this->currentDate->copy()->endOfMonth())
            ->sum('hours') / 7;

        $this->timeRemaining = round($this->client->retainer - $hoursUsedThisMonth, 2);

        $hoursUsedToday = $this->client->timeEntries()
            ->where('date', '>=', $this->currentDate->copy()->startOfDay())
            ->where('date', '<=', $this->currentDate->copy()->endOfDay())
            ->sum('hours') / 7;

        $this->timeUsedToday = round($hoursUsedToday, 2);
    }

    public function deleteTimeEntry(TimeEntry $timeEntry)
    {
        // $this->authorize('delete', $timeEntry);

        $timeEntry->delete();
    }

    public function refreshTimeEntries()
    {
        $this->getStats();
        $this->getEntries();
    }

    public function getListeners()
    {
        return [
            'refreshTimeEntries',
        ];
    }

    public function render()
    {
        if ($this->client) {
            $this->getStats();
        }

        return view('livewire.time-entries.index', [
            'items' => $this->client ? $this->getEntries() : [],
        ]);
    }
}
