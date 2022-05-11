<div>
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('projects.index') }}
    </x-slot>

    <x-slot name="actions">
        <button type="button" x-on:click="Livewire.emit('toggleCreateProjectModal')">
            <x-heroicon-o-plus-circle class="w-6 h-6 text-gray-400" />
        </button>
    </x-slot>

    @livewire('projects.form')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if ($items->count())
            <x-grid-list>
                @foreach ($items as $item)
                    <x-project.item :item="$item" />
                @endforeach
            </x-grid-list>
        @else
            <x-empty-card />
        @endif
    </div>
</div>
