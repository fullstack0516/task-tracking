@props(['item'])

<x-card class="flex items-center justify-between space-x-6">
    <div class="flex items-center space-x-3 truncate">
        <x-badge :model="$item" />

        <div class="flex-auto truncate">
            <h3 class="text-gray-900 dark:text-white text-sm font-medium truncate">
                {{ $item->name }}
            </h3>

            <p class="mt-0.5 text-gray-500 dark:text-gray-300 text-sm truncate">
                {{ $item->client->company }}
            </p>
        </div>
    </div>

    <div class="flex items-center space-x-3">
        @if ($item->repository_url)
            <x-link href="{{ $item->repository_url }}" target="_blank">
                <x-heroicon-o-code class="h-6 w-6 text-accent opacity-20 hover:opacity-100" />
            </x-link>
        @endif

        <x-link href="{{ route('projects.overview', $item) }}">
            <x-heroicon-o-eye class="h-6 w-6 text-accent opacity-20 hover:opacity-100" />
        </x-link>

        <x-link href="#!" wire:click="$emit('toggleEditProjectModal', {{ $item->id }})">
            <x-heroicon-o-pencil-alt class="h-6 w-6 text-accent opacity-20 hover:opacity-100" />
        </x-link>
    </div>
</x-card>
