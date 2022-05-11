<?php

namespace App\Http\Livewire\TimeEntries;

use App\Models\Client;
use App\Models\TimeEntry;
use App\Traits\HasFormTarget;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Form extends Component
{
    use AuthorizesRequests,
        HasFormTarget;

    public Client $client;

    public TimeEntry $timeEntry;

    public $state = [];

    public bool $showModal = false;

    public function toggleCreateTimeEntryModal()
    {
        $this->state = [
            'date' => now()->format('Y-m-d'),
        ];
        $this->setTarget('create');
        $this->toggleModal();
    }

    public function toggleEditTimeEntryModal(TimeEntry $timeEntry)
    {
        if ($timeEntry->exists) {
            $this->timeEntry = $timeEntry;
            $this->client = $this->client->exists ? $this->client : $this->timeEntry->client;
            $this->state = $timeEntry->toArray();
            $this->setTarget('update');
            $this->toggleModal();
        }
    }

    public function create()
    {
        $data = Validator::make($this->state, $this->rules())->validate();

        // $this->authorize('create', TimeEntry::class);

        $startOfMonth = Carbon::createFromFormat('Y-m-d', $data['date'])->startOfMonth();
        $endOfMonth = Carbon::createFromFormat('Y-m-d', $data['date'])->endOfMonth();

        $retainer = $this->client->retainers()->firstOrCreate([
            'starts_at' => $startOfMonth->format('Y-m-d'),
            'ends_at' => $endOfMonth->format('Y-m-d'),
        ], [
            'starts_at' => $startOfMonth,
            'ends_at' => $endOfMonth,
            'days' => $this->client->retainer,
        ]);

        $retainer->timeEntries()->create($data + [
            'client_id' => $this->client->id,
            'user_id' => auth()->id(),
        ]);

        $this->emitUp('refreshTimeEntries');

        $this->toggleModal();
    }

    public function update()
    {
        $data = Validator::make($this->state, $this->rules())->validate();

        // $this->authorize('update', $this->timeEntry);

        $startOfMonth = Carbon::createFromFormat('Y-m-d', $data['date'])->startOfMonth();
        $endOfMonth = Carbon::createFromFormat('Y-m-d', $data['date'])->endOfMonth();

        $retainer = $this->client->retainers()->firstOrCreate([
            'starts_at' => $startOfMonth->format('Y-m-d'),
            'ends_at' => $endOfMonth->format('Y-m-d'),
        ], [
            'starts_at' => $startOfMonth,
            'ends_at' => $endOfMonth,
            'days' => $this->client->retainer,
        ]);

        $this->timeEntry->update(array_merge($data, [
            'retainer_id' => $retainer->id,
        ]));

        $this->emitUp('refreshTimeEntries');

        $this->toggleModal();
    }

    public function delete()
    {
        // $this->authorize('delete', $this->timeEntry);

        $this->timeEntry->delete();

        $this->emitUp('refreshTimeEntries');

        $this->toggleModal();
    }

    public function toggleModal()
    {
        $this->showModal = ! $this->showModal;
    }

    public function rules()
    {
        return [
            'date' => ['required', 'date'],
            'hours' => ['required', 'min:0'],
            'task' => ['nullable', 'string', 'max:255'],
            'note' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function getListeners()
    {
        return [
            'toggleCreateTimeEntryModal',
            'toggleEditTimeEntryModal',
            'toggleTimeEntryModal' => 'toggleModal',
        ];
    }

    public function render()
    {
        return view('livewire.time-entries.form');
    }
}
