<?php

namespace App\Http\Livewire\TaskGroups;

use App\Events\TaskPositionUpdated;
use App\Models\Project;
use Illuminate\Support\Collection;
use Livewire\Component;

class Listing extends Component
{
    public Project $project;

    public Collection $taskGroups;

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->taskGroups = $project->taskGroups;
    }

    public function updateTaskOrder(array $groups)
    {
        $tasks = [];

        foreach ($groups as $group) {
            $taskGroupId = $group['value'];

            foreach ($group['items'] as $task) {
                $tasks[] = [
                    'id' => $task['value'],
                    'task_group_id' => $taskGroupId,
                    'position' => $task['order'],
                ];
            }
        }

        foreach ($this->project->tasks as $task) {
            foreach ($tasks as $newTask) {
                if ($task->id != $newTask['id']) {
                    continue;
                }

                unset($newTask['id']);

                $task->update($newTask);
            }
        }

        broadcast(new TaskPositionUpdated($this->project->withoutRelations()))->toOthers();

        $this->emit('refreshTasks');
    }

    public function refreshTasks()
    {
        $this->taskGroups = $this->project->fresh()->taskGroups;
    }

    public function taskModified(array $data)
    {
        $this->refreshTasks();
    }

    public function getListeners()
    {
        return [
            'refreshTasks',
            'echo-private:projects.'.$this->project->id.',TaskCreated' => 'taskModified',
            'echo-private:projects.'.$this->project->id.',TaskUpdated' => 'taskModified',
            'echo-private:projects.'.$this->project->id.',TaskDeleted' => 'taskModified',
            'echo-private:projects.'.$this->project->id.',TaskPositionUpdated' => 'taskModified',
        ];
    }

    public function render()
    {
        return view('livewire.task-groups.listing');
    }
}
