<?php

namespace App\Http\Livewire\Crm\Prospects;

use App\Models\Prospect;
use Livewire\Component;

class Show extends Component
{
    public Prospect $prospect;

    public $communications;

    public function mount(Prospect $prospect)
    {
        $this->prospect = $prospect;
    }

    public function render()
    {
        return view('livewire.crm.prospects.show');
    }
}
