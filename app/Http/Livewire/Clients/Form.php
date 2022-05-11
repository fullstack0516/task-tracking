<?php

namespace App\Http\Livewire\Clients;

use App\Models\Client;
use App\Rules\Hex;
use App\Traits\HasFormTarget;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Livewire\Component;

class Form extends Component
{
    use HasFormTarget;

    public Client $client;

    public $state = [
        'public_overview' => false,
    ];

    public bool $showModal = false;

    public function toggleCreateClientModal()
    {
        $this->state = [];
        $this->setTarget('create');
        $this->toggleModal();
    }

    public function toggleEditClientModal(Client $client)
    {
        if ($client->exists) {
            $this->client = $client;
            $this->state = array_merge($client->toArray(), [
                'public_overview' => $client->uuid ? true : false,
            ]);
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

        // $this->authorize('create', Client::class);

        auth()->user()->currentTeam->clients()->create($data);

        $this->emitUp('refreshClients');

        $this->toggleModal();
    }

    public function update()
    {
        $data = Validator::make($this->state, $this->rules())->validate();

        // $this->authorize('update', $this->client);

        if ($data['public_overview'] ?? false) {
            unset($data['public_overview']);

            $data['uuid'] = Str::uuid()->toString();
        } else {
            $data['uuid'] = null;
        }

        $this->client->update($data);

        $this->emitUp('refreshClients');

        $this->toggleModal();
    }

    public function delete()
    {
        // $this->authorize('delete', $this->client);

        $this->client->delete();

        $this->emitUp('refreshClients');

        $this->toggleModal();
    }

    public function rules()
    {
        return [
            'company' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'retainer' => ['nullable', 'string', 'max:255'],
            'colour' => ['nullable', new Hex],
            'uuid' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function getListeners()
    {
        return [
            'toggleCreateClientModal',
            'toggleEditClientModal',
            'toggleClientModal' => 'toggleModal',
        ];
    }

    public function render()
    {
        return view('livewire.clients.form');
    }
}
