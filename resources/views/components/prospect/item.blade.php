@props(['item'])

<x-card class="flex items-center justify-between space-x-6">
    <div>
        <h3 class="text-gray-900 dark:text-white text-sm font-medium truncate">
            {{ $item->company }}
        </h3>

        <p class="mt-0.5 text-gray-500 dark:text-gray-300 text-sm truncate">
            {{ $item->updated_at->longAbsoluteDiffForHumans() }} {{ __('since last contact') }}
        </p>
    </div>

    <div class="flex items-center space-x-3">
        <x-link href="{{ route('crm.prospects.show', $item) }}">
            <x-heroicon-o-eye class="h-6 w-6 text-accent opacity-20 hover:opacity-100" />
        </x-link>

        <x-link href="#!" wire:click="$emit('toggleEditProspectModal', {{ $item->id }})">
            <x-heroicon-o-pencil-alt class="h-6 w-6 text-accent opacity-20 hover:opacity-100" />
        </x-link>
    </div>
</x-card>
