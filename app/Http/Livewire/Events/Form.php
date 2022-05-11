<?php

namespace App\Http\Livewire\Events;

use App\Models\Event;
use App\Models\Project;
use App\Models\User;
use App\Traits\HasFormTarget;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Form extends Component
{
    use AuthorizesRequests,
        HasFormTarget;

    public Project $project;

    public Event $event;

    public array $state = [];

    public Collection $users;

    public bool $showModal = false;

    public function mount(Project $project)
    {
        $this->project = $project;

        $teamUserIds = auth()->user()->currentTeam->allUsers()->pluck('id');

        $this->users = User::whereIn('id', $teamUserIds)->get();
    }

    public function toggleCreateEventModal(string $currentDate)
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate);

        $this->state = [
            'starts_at' => $date->format('Y-m-d'),
            'ends_at' => $date->format('Y-m-d'),
        ];
        $this->setTarget('create');
        $this->toggleModal();
    }

    public function toggleEditEventModal(Event $event)
    {
        if ($event->exists) {
            $this->event = $event;
            $this->state = array_merge($event->toArray(), [
                'starts_at' => $event->starts_at->format('Y-m-d'),
                'ends_at' => $event->ends_at->format('Y-m-d'),
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

        // $this->authorize('create', Event::class);

        $data['user_id'] = auth()->id();

        auth()->user()->currentTeam->events()->create($data);

        $this->emitUp('refreshEvents');

        $this->toggleModal();
    }

    public function update()
    {
        $data = Validator::make($this->state, $this->rules())->validate();

        // $this->authorize('update', $this->event);

        $this->event->update($data);

        $this->emitUp('refreshEvents');

        $this->toggleModal();
    }

    public function delete()
    {
        // $this->authorize('delete', $this->event);

        $this->event->delete();

        $this->emitUp('refreshEvents');

        $this->toggleModal();
    }

    public function rules()
    {
        return [
            'type' => ['required', 'in:holiday,meeting,sick,other'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after_or_equal:starts_at'],
            'note' => ['nullable', 'string', 'max:255', 'required_if:type,other'],
        ];
    }

    public function getListeners()
    {
        return [
            'toggleCreateEventModal',
            'toggleEditEventModal',
            'toggleEventModal' => 'toggleModal',
        ];
    }

    public function render()
    {
        return view('livewire.events.form');
    }
}
