<?php

namespace App\Http\Livewire\Crm\Dashboard;

use App\Models\Team;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Chart extends Component
{
    public int $prospects;

    public array $prospectsByMonth;

    public array $clientsByMonth;

    public array $chartHeaders = [];

    public array $chartKeys = [];

    public Carbon $start;

    public Team $team;

    public function mount()
    {
        $this->team = auth()->user()->currentTeam;
        $this->getChartData();
    }

    public function getChartData()
    {
        $this->start = now()->subMonths(11)->startOfMonth();
        $this->setChartHeaders();
        $this->getChartKeys();
        $this->getProspectsChartData();
        $this->getClientsChartData();
    }

    public function getProspectsChartData()
    {
        $this->prospectsByMonth = $this->team->prospects()
            ->selectRaw("count(id) total, DATE_FORMAT(`created_at`,'%Y%m') date")
            ->where('created_at', '>=', $this->start)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->pluck('total', 'date')
            ->toArray();

        $this->prospectsByMonth = $this->prospectsByMonth + $this->chartKeys;
        ksort($this->prospectsByMonth);
    }

    public function getClientsChartData()
    {
        $this->clientsByMonth = $this->team->clients()
            ->selectRaw("count(id) total, DATE_FORMAT(`created_at`,'%Y%m') date")
            ->where('created_at', '>=', $this->start)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->pluck('total', 'date')
            ->toArray();

        $this->clientsByMonth = $this->clientsByMonth + $this->chartKeys;
        ksort($this->clientsByMonth);
    }

    public function getChartKeys()
    {
        $start = now()->subMonths(11)->startOfMonth();
        for ($i = 0; $i < 12; $i++) {
            $this->chartKeys[$start->format('Ym')] = 0;
            $start->addMonth(1)->startOfMonth();
        }
    }

    public function setChartHeaders()
    {
        $start = now()->subMonths(11)->startOfMonth();
        for ($i = 0; $i < 12; $i++) {
            $this->chartHeaders[$start->format('Ym')] = $start->format('M');
            $start->addMonth(1)->startOfMonth();
        }
    }

    public function render()
    {
        return view('livewire.crm.dashboard.chart');
    }
}
