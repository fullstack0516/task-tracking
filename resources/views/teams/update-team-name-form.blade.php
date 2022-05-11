<x-card>
    <form class="space-y-6" wire:submit="updateTeamName">
        <!-- Team Owner Information -->
        <div class="col-span-6">
            <x-jet-label value="{{ __('Team Owner') }}" />

            <div class="flex items-center mt-2">
                <img class="w-12 h-12 rounded-full object-cover" src="{{ $team->owner->profile_photo_url }}" alt="{{ $team->owner->name }}">

                <div class="ml-4 leading-tight">
                    <div>{{ $team->owner->name }}</div>
                    <div class="text-gray-700 text-sm">{{ $team->owner->email }}</div>
                </div>
            </div>
        </div>

        <!-- Team Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Team Name') }}" />

            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" :disabled="! Gate::check('update', $team)" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        @if (Gate::check('update', $team))
            <x-slot name="actions">
                <x-jet-button>
                    {{ __('Save') }}
                </x-jet-button>

                <x-jet-action-message class="ml-3" on="saved">
                    {{ __('Saved.') }}
                </x-jet-action-message>
            </x-slot>
        @endif
    </form>
</x-card>
