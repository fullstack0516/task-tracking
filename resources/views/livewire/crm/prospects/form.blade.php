<x-slideout max-width="4xl" wire:model="showModal">
    <x-slot name="title">
        {{ __(sprintf('%s Prospect', ucfirst($target))) }}
    </x-slot>

    <form class="space-y-4" wire:submit.prevent="{{ $target }}">
        <div>
            <x-jet-label for="company" value="{{ __('Company') }}" />
            <x-jet-input id="company" class="block mt-1 w-full" type="text" wire:model.defer="state.company" />
            <x-jet-input-error for="state.company" class="mt-2" />
        </div>

        <div>
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" class="block mt-1 w-full" type="text" wire:model.defer="state.name" />
            <x-jet-input-error for="state.name" class="mt-2" />
        </div>

        <div>
            <x-jet-label for="email" value="{{ __('Email') }}" />
            <x-jet-input id="email" class="block mt-1 w-full" type="email" wire:model.defer="state.email" />
            <x-jet-input-error for="state.email" class="mt-2" />
        </div>

        <div>
            <x-jet-label for="phone" value="{{ __('Phone') }}" />
            <x-jet-input id="phone" class="block mt-1 w-full" type="text" wire:model.defer="state.phone" />
            <x-jet-input-error for="state.phone" class="mt-2" />
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
