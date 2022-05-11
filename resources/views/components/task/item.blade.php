@props(['task'])

<x-card
    class="w-80 flex flex-col items-start justify-between hover:cursor-pointer"
    wire:click.prevent="$emit('toggleEditTaskModal', {{ $task->id }})"
    wire:key="task-{{ $task->id }}"
    wire:sortable-group.item="{{ $task->id }}"
>
    <div>
        <div class="mb-5 w-full flex items-center justify-between space-x-6">
            <div class="flex flex-wrap items-center gap-2">
                <x-task.id id="{{ $task->id }}" priority="{{ $task->priority }}" />

                <x-task.type type="{{ $task->type }}" />
            </div>
        </div>

        {{-- initial task title --}}
        <p class="text-sm font-semibold text-gray-800 leading-tight">
            {{ $task->title }}
        </p>
    </div>

    <div class="w-full">
        {{-- show task assignees --}}
        @if ($task->assignees->count())
            <div class="mt-6 w-full flex items-center justify-between">
                <div class="flex -space-x-1 relative z-0 overflow-hidden">
                    @foreach ($task->assignees as $index => $assignee)
                        <img class="relative inline-block h-6 w-6 rounded-full ring-[3px] ring-white object-cover" style="z-index: {{ $index }};" src="{{ $assignee->profile_photo_url }}" alt="{{ $assignee->name }}">
                    @endforeach
                </div>

                <div class="flex items-center space-x-2">
                    {{-- show if a task has an attachment --}}
                    @if ($attachmentCount = $task->attachments->count())
                        <span class="flex items-center text-xs font-medium text-gray-400 leading-tight">
                            <x-heroicon-o-paper-clip class="h-4 w-4 mr-1" /> {{ $attachmentCount }}
                        </span>
                    @endif

                    {{-- show if a task has a description --}}
                    @if (strip_tags($task->description))
                        <x-heroicon-o-document-text class="h-4 w-4 mr-1 text-gray-400" />
                    @endif

                    {{-- show if a task has child tasks --}}
                    @if ($task->tasks->count())
                        <span class="flex items-center text-xs font-medium text-gray-400 leading-tight">
                            <x-heroicon-o-check-circle class="h-4 w-4 mr-1" /> {{ $task->tasksComplete }}/{{ $task->tasks->count() }}
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</x-card>
