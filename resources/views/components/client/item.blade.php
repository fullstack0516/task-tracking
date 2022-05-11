@props(['item'])

<x-card class="flex items-center justify-between space-x-6">
    <div class="flex items-center space-x-3 truncate">
        <x-badge :model="$item" />

        <div class="flex-auto truncate">
            <h3 class="text-gray-900 dark:text-white text-sm font-medium truncate">
                {{ $item->company }}
            </h3>

            <p class="mt-0.5 text-gray-500 dark:text-gray-300 text-sm truncate">
                {{ $item->name }}
            </p>
        </div>
    </div>

    <div class="flex items-center space-x-3">
        <x-link href="{{ route('clients.show', $item) }}">
            <x-heroicon-o-eye class="h-6 w-6 text-accent opacity-20 hover:opacity-100" />
        </x-link>

        <x-link href="#!" wire:click="$emit('toggleEditClientModal', {{ $item->id }})">
            <x-heroicon-o-pencil-alt class="h-6 w-6 text-accent opacity-20 hover:opacity-100" />
        </x-link>
    </div>
</x-card>
