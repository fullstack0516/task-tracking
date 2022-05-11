<x-slideout max-width="4xl" wire:model="showModal">
    <x-slot name="title">
        {{ __(sprintf('%s Event', ucfirst($target))) }}
    </x-slot>

    <form class="space-y-4" wire:submit.prevent="{{ $target }}">
        <div>
            <x-jet-label for="type" value="{{ __('Type') }}" />
            <x-select id="type" class="block mt-1 w-full" wire:model.defer="state.type">
                <option value="">{{ __('Select an option') }}</option>
                <option value="holiday">{{ __('Holiday') }}</option>
                <option value="meeting">{{ __('Meeting') }}</option>
                <option value="sick">{{ __('Sick') }}</option>
                <option value="other">{{ __('Other') }}</option>
            </x-select>
            <x-jet-input-error for="type" class="mt-2" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-jet-label for="starts_at" value="{{ __('Starts At') }}" />
                <x-jet-input id="starts_at" class="block mt-1 w-full" type="date" wire:model.defer="state.starts_at" />
                <x-jet-input-error for="starts_at" class="mt-2" />
            </div>

            <div>
                <x-jet-label for="ends_at" value="{{ __('Ends At') }}" />
                <x-jet-input id="ends_at" class="block mt-1 w-full" type="date" wire:model.defer="state.ends_at" />
                <x-jet-input-error for="ends_at" class="mt-2" />
            </div>
        </div>

        <div>
            <x-jet-label for="note" value="{{ __('Note') }}" />
            <x-jet-input id="note" class="block mt-1 w-full" type="text" wire:model.defer="state.note" />
            <x-jet-input-error for="note" class="mt-2" />
        </div>

        @if ($this->isTarget('update'))
            <x-danger-button x-on:click="confirm('Are you sure you want to delete this?') ? $wire.delete() : null">
                {{ __('Delete') }}
            </x-danger-button>
        @endif

        <x-slot name="actions">
            <x-jet-button class="w-full justify-center" x-on:click="$wire.{{ $target }}()">
                {{ __(ucfirst($target)) }}
            </x-jet-button>
        </x-slot>
    </form>
</x-slideout>
