<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use App\Rules\Hex;
use App\Traits\HasFormTarget;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use AuthorizesRequests,
        HasFormTarget,
        WithFileUploads;

    public Project $project;

    public Collection $clients;

    public array $state = [];

    public bool $showModal = false;

    public function mount()
    {
        $this->clients = auth()->user()->currentTeam->clients;
    }

    public function toggleCreateProjectModal()
    {
        $this->state = [];
        $this->setTarget('create');
        $this->toggleModal();
    }

    public function toggleEditProjectModal(Project $project)
    {
        if ($project->exists) {
            $this->project = $project;
            $this->state = $project->toArray();
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

        $this->authorize('create', Project::class);

        auth()->user()->currentTeam->projects()->create($data);

        $this->emitUp('refreshProjects');

        $this->toggleModal();
    }

    public function update()
    {
        $data = Validator::make($this->state, $this->rules())->validate();

        $this->authorize('update', $this->project);

        $this->project->update($data);

        $this->emitUp('refreshProjects');

        $this->toggleModal();
    }

    public function delete()
    {
        $this->authorize('delete', $this->project);

        $this->project->delete();

        $this->emitUp('refreshProjects');

        $this->toggleModal();
    }

    public function rules()
    {
        return [
            'client_id' => ['required', 'exists:clients,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'repository_url' => ['nullable', 'string', 'max:255'],
            'colour' => ['nullable', new Hex],
            'notifies_slack' => ['nullable', 'boolean'],
        ];
    }

    public function getListeners()
    {
        return [
            'toggleCreateProjectModal',
            'toggleEditProjectModal',
            'toggleProjectModal' => 'toggleModal',
        ];
    }

    public function render()
    {
        return view('livewire.projects.form');
    }
}
