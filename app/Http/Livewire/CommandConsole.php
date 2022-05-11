<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CommandConsole extends Component
{
    public string $query = '';

    public array $itemGroups = [];

    public function updatedQuery()
    {
        $this->itemGroups['projects'] = $this->getProjects();
        $this->itemGroups['clients'] = $this->getClients();
    }

    public function getProjects()
    {
        return auth()->user()->currentTeam->projects()
            ->where('name', 'like', '%'.$this->query.'%')
            ->get();
    }

    public function getClients()
    {
        return auth()->user()->currentTeam->clients()
            ->where('name', 'like', '%'.$this->query.'%')
            ->orWhere('company', 'like', '%'.$this->query.'%')
            ->get();
    }

    public function render()
    {
        return view('livewire.command-console');
    }
}
