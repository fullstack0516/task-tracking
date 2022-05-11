<?php

namespace App\Http\Livewire\Crm\Prospects;

use App\Models\Prospect;
use App\Traits\HasFormTarget;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Form extends Component
{
    use HasFormTarget,
        AuthorizesRequests;

    public Prospect $prospect;

    public array $state = [];

    public bool $showModal = false;

    public function toggleCreateProspectModal()
    {
        $this->state = [];
        $this->setTarget('create');
        $this->toggleModal();
    }

    public function toggleEditProspectModal(Prospect $prospect)
    {
        if ($prospect->exists) {
            $this->prospect = $prospect;
            $this->state = $prospect->toArray();
            $this->setTarget('update');
            $this->toggleModal();
        }
    }

    public function toggleModal()
    {
        $this->showModal = ! $this->showModal;
    }

    public function create()
    {
        $data = Validator::make($this->state, $this->rules())->validate();

        $this->authorize('create', Prospect::class);

        auth()->user()->currentTeam->prospects()->create($data);

        $this->emitUp('refreshProspects');

        $this->toggleModal();
    }

    public function update()
    {
        $data = Validator::make($this->state, $this->rules())->validate();

        $this->authorize('update', $this->prospect);

        $this->prospect->update($data);

        $this->emitUp('refreshProspects');

        $this->toggleModal();
    }

    public function delete()
    {
        $this->authorize('delete', $this->prospect);

        $this->prospect->delete();

        $this->emitUp('refreshProspects');

        $this->toggleModal();
    }

    public function rules()
    {
        return [
            'company' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function getListeners()
    {
        return [
            'toggleCreateProspectModal',
            'toggleEditProspectModal',
            'toggleProspectModal' => 'toggleModal',
        ];
    }

    public function render()
    {
        return view('livewire.crm.prospects.form');
    }
}
