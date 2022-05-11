<div>
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('projects.overview', $project) }}
    </x-slot>

    <x-slot name="actions">
        <div class="flex items-center space-x-2">
            <x-link href="{{ route('projects.overview', $project) }}">
                <x-heroicon-o-view-grid class="w-6 h-6 text-gray-400" />
            </x-link>

            @if ($project->repository_url)
                <x-link href="{{ $project->repository_url }}" target="_blank">
                    <x-heroicon-o-code class="w-6 h-6 text-gray-400" />
                </x-link>
            @endif

            <x-link href="#!" x-on:click="Livewire.emit('toggleEditProjectModal', {{ $project->id }})">
                <x-heroicon-o-cog class="w-6 h-6 text-gray-400" />
            </x-link>
        </div>
    </x-slot>

    @livewire('projects.form')

    @livewire('tasks.form', ['project' => $project])

    @livewire('task-groups.listing', ['project' => $project])
</div>
