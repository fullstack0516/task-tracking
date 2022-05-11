<?php

namespace App\Http\Livewire\Clients;

use App\Exports\TimesheetExport;
use App\Models\Client;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Overview extends Component
{
    public ?Client $client;

    public $currentDate;

    public $timeUsedLastMonth;

    public $timeUsedForMonth;

    public $timeRemaining;

    public function mount(string $uuid)
    {
        $this->client = Client::whereUuid($uuid)->firstOrFail();
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

        $hoursUsed = $this->client->timeEntries()
            ->where('date', '>=', $this->currentDate->copy()->startOfMonth())
            ->where('date', '<=', $this->currentDate->copy()->endOfMonth())
            ->sum('hours') / 7;

        $this->timeRemaining = round($this->client->retainer - $hoursUsed, 2);
    }

    public function render()
    {
        if ($this->client) {
            $this->getStats();
        }

        return view('livewire.clients.overview', [
            'items' => $this->client ? $this->getEntries() : [],
        ])->layout('layouts.client');
    }
}
