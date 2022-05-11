<?php

namespace App\Http\Livewire\Credentials;

use App\Models\Credential;
use App\Models\User;
use App\Traits\HasFormTarget;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Form extends Component
{
    use AuthorizesRequests,
        HasFormTarget;

    public Credential $credential;

    public Collection $users;

    public array $state = [];

    public bool $showModal = false;

    public function mount()
    {
        $teamUserIds = auth()->user()->currentTeam->allUsers()->pluck('id');

        $this->users = User::whereIn('id', $teamUserIds)->get();
    }

    public function toggleCreateCredentialModal()
    {
        $this->state = [];
        $this->setTarget('create');
        $this->toggleModal();
    }

    public function toggleEditCredentialModal(Credential $credential)
    {
        if ($credential->exists) {
            $this->credential = $credential;
            $this->state = $credential->toArray();
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

        // $this->authorize('create', Credential::class);

        auth()->user()->currentTeam->credentials()->create($data);

        $this->emitUp('refreshCredentials');

        $this->toggleModal();
    }

    public function update()
    {
        $data = Validator::make($this->state, $this->rules())->validate();

        // $this->authorize('update', $this->credential);

        $this->credential->update($data);

        $this->emitUp('refreshCredentials');

        $this->toggleModal();
    }

    public function delete()
    {
        // $this->authorize('delete', $this->credential);

        $this->credential->delete();

        $this->emitUp('refreshCredentials');

        $this->toggleModal();
    }

    public function rules()
    {
        return [
            'service' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'max:255'],
            'user_id' => ['required', 'exists:clients,id'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function getListeners()
    {
        return [
            'toggleCreateCredentialModal',
            'toggleEditCredentialModal',
            'toggleCredentialModal' => 'toggleModal',
        ];
    }

    public function render()
    {
        return view('livewire.credentials.form');
    }
}
