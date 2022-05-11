<div>
    <div
        class="px-4 sm:px-6 lg:px-11 flex space-x-8 overflow-x-auto scrollbar-hide"
        wire:sortable-group="updateTaskOrder"
        id="task-groups"
    >
        @forelse ($project->taskGroups as $taskGroup)
            <div
                class="flex flex-col flex-shrink-0"
                wire:key="group-{{ $taskGroup->id }}"
                wire:sortable.item="{{ $taskGroup->id }}"
            >
                <div class="flex justify-between items-center space-x-8">
                    <div class="flex items-center space-x-3">
                        <h3 class="text-xs tracking-wide font-semibold uppercase text-gray-700 leading-tight">
                            {{ $taskGroup->name }}
                        </h3>

                        <span class="text-xs tracking-wide font-semibold uppercase text-gray-400 leading-tight">
                            {{ $taskGroup->tasks->count() }}
                        </span>
                    </div>

                    <button
                        type="button"
                        class="text-gray-300 hover:text-gray-700 transition"
                        wire:click="$emit('toggleCreateTaskModal', {{ $taskGroup->id }})"
                    >
                        <x-heroicon-s-plus-circle class="h-6 w-6" />
                    </button>
                </div>

                <div
                    class="mt-3 w-80 space-y-3 relative {{ $taskGroup->tasks->count() ? 'clipped pb-6' : '' }} flex-grow max-h-[48rem] overflow-y-scroll"
                    wire:sortable-group.item-group="{{ $taskGroup->id }}"
                >
                    @foreach ($taskGroup->tasks as $task)
                        <x-task.item :task="$task" />
                    @endforeach
                </div>
            </div>
        @empty
            <x-card>
                {{ __('No task groups') }}
            </x-card>
        @endforelse
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            setupTaskGroupListing();
        });

        window.addEventListener('resize', () => {
            setupTaskGroupListing();
        });

        function setupTaskGroupListing() {
            const taskGroups = document.getElementById('task-groups');
            const header = document.getElementById('header');

            if (taskGroups && header) {
                taskGroups.style.paddingLeft = `calc(${header.offsetLeft}px - 2.75rem)`;
                taskGroups.style.paddingRight = `calc(${header.offsetLeft}px - 2.75rem)`;
            }
        }
    </script>
</div>
