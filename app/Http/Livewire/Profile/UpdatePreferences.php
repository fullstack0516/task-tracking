<?php

namespace App\Http\Livewire\Profile;

use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class UpdatePreferences extends Component
{
    public array $state = [
        'dark_mode' => false,
        'compact_mode' => true,
        'colour' => 'indigo',
    ];

    public $rules = [
        'dark_mode' => ['required'],
        'compact_mode' => ['required'],
        'colour' => ['required'],
    ];

    public function mount()
    {
        $this->state = [
            'dark_mode' => auth()->user()->theme === 'dark',
            'compact_mode' => auth()->user()->compact,
            'colour' => auth()->user()->colour,
        ];
    }

    public function updatePreferences()
    {
        $data = Validator::make($this->state, $this->rules)->validate();

        auth()->user()->update([
            'theme' => $data['dark_mode'] ? 'dark' : 'light',
            'compact' => $data['compact_mode'],
            'colour' => $data['colour'],
        ]);
    }

    public function render()
    {
        return view('livewire.profile.update-preferences');
    }
}
