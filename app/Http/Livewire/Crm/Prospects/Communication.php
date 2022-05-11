<?php

namespace App\Http\Livewire\Crm\Prospects;

use App\Models\Prospect;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Communication extends Component
{
    public Prospect $prospect;

    public array $state = [];

    public function mount(Prospect $prospect)
    {
        $this->prospect = $prospect;
    }

    public function submit()
    {
        $data = Validator::make($this->state, $this->rules())->validate();

        $this->prospect->communications()->create($data);

        $this->prospect->touch();

        $this->emitUp('refreshCommunications');
    }

    public function rules()
    {
        return [
            'description' => ['required', 'string', 'max:5000'],
            'type' => ['required', 'in:email,phone,irl,other'],
        ];
    }

    public function render()
    {
        return view('livewire.crm.prospects.communication');
    }
}
