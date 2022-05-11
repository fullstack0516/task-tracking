<?php

namespace App\Http\Livewire\Tasks;

use App\Events\TaskCreated;
use App\Events\TaskDeleted;
use App\Events\TaskUpdated;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskGroup;
use App\Models\User;
use App\Notifications\TaskAddedNotification;
use App\Traits\HasFormTarget;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use AuthorizesRequests,
        HasFormTarget,
        WithFileUploads;

    public Project $project;

    public TaskGroup $taskGroup;

    public Task $task;

    public array $state = [
        'description' => '',
        'task_group_id' => '',
        'type' => '',
        'priority' => '',
        'assignees' => [],
    ];

    public Collection $users;

    public bool $showModal = false;

    public $file;

    protected $listeners = [
        'toggleCreateTaskModal',
        'toggleEditTaskModal',
        'toggleTaskModal' => 'toggleModal',
    ];

    public function mount(Project $project)
    {
        $this->project = $project;

        $teamUserIds = auth()->user()->currentTeam->allUsers()->pluck('id');

        $this->users = User::whereIn('id', $teamUserIds)->get();
    }

    public function toggleCreateTaskModal(TaskGroup $taskGroup)
    {
        $this->taskGroup = $taskGroup;
        $this->state = [
            'task_group_id' => $taskGroup->id,
            'type' => 'task',
            'priority' => 'low',
            'assignees' => [auth()->id()],
        ];
        $this->setTarget('create');
        $this->toggleModal();
        $this->dispatchBrowserEvent('editor', ['description' => '']);
    }

    public function toggleEditTaskModal(Task $task)
    {
        if ($task->exists) {
            $this->task = $task;
            $this->project = $this->project->exists ? $this->project : $this->task->taskGroup->project;
            $this->state = $task->toArray();
            $this->state['assignees'] = $task->assignees->pluck('id');
            $this->setTarget('update');
            $this->toggleModal();
            $this->dispatchBrowserEvent('editor', ['description' => $task->description]);
        }
    }

    public function toggleModal()
    {
        $this->showModal = ! $this->showModal;
    }

    public function create()
    {
        $data = Validator::make($this->state, $this->rules())->validate();

        // $this->authorize('create', Task::class);

        $taskGroup = $this->project->taskGroups()->find($data['task_group_id']);

        foreach ($taskGroup->tasks as $task) {
            $task->update([
                'position' => $task->position + 1,
            ]);
        }

        $task = $this->taskGroup->tasks()->create($data + [
            'position' => 1,
        ]);

        if (isset($this->state['assignees'])) {
            $task->assignees()->sync($this->state['assignees']);
        }

        if ($this->file) {
            $this->task->attachments()->create([
                'filename' => $this->file->getClientOriginalName(),
                'mime' => $this->file->getClientMimeType(),
                'cloudname' => $this->file->store('tasks', 'spaces'),
                'size' => $this->file->getSize(),
            ]);
        }

        if ($this->project->notifies_slack ?? false) {
            auth()->user()->notify(new TaskAddedNotification($task));
        }

        broadcast(new TaskCreated($task))->toOthers();

        $this->emit('refreshTasks');

        $this->toggleModal();
    }

    public function update()
    {
        $data = Validator::make($this->state, $this->rules())->validate();

        // $this->authorize('update', $this->task);

        $this->task->update($data);

        if (isset($this->state['assignees'])) {
            $this->task->assignees()->sync($this->state['assignees']);
        }

        if ($this->file) {
            $this->task->attachments()->create([
                'filename' => $this->file->getClientOriginalName(),
                'mime' => $this->file->getClientMimeType(),
                'cloudname' => $this->file->store('tasks', 'spaces'),
                'size' => $this->file->getSize(),
            ]);
        }

        broadcast(new TaskUpdated($this->task))->toOthers();

        $this->emit('refreshTasks');

        $this->toggleModal();
    }

    public function delete()
    {
        // $this->authorize('delete', $this->task);

        $this->task->delete();

        broadcast(new TaskDeleted($this->task))->toOthers();

        $this->emit('refreshTasks');

        $this->toggleModal();
    }

    public function clearAssignees()
    {
        $this->state['assignees'] = [];
    }

    public function deleteAttachment(int $attachmentId)
    {
        $attachment = $this->task->attachments()->findOrFail($attachmentId);

        Storage::disk('spaces')->delete($attachment->cloudname);

        $attachment->delete();
    }

    public function rules()
    {
        return [
            'task_group_id' => ['required', 'exists:task_groups,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:999'],
            'type' => ['required', 'in:story,task,bug'],
            'priority' => ['required', 'in:low,medium,high'],
            'parent_task_id' => ['nullable', 'exists:tasks,id'],
        ];
    }

    public function render()
    {
        return view('livewire.tasks.form');
    }
}
