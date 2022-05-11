<x-slideout max-width="4xl" wire:model="showModal">
    <x-slot name="title">
        {{ __(sprintf('%s Time Entry', ucfirst($target))) }}
    </x-slot>

    <form class="space-y-4" wire:submit.prevent="{{ $target }}">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-jet-label for="date" value="{{ __('Date') }}" />
                <x-jet-input id="date" class="block mt-1 w-full" type="date" wire:model.defer="state.date" />
                <x-jet-input-error for="date" class="mt-2" />
            </div>

            <div>
                <x-jet-label for="hours" value="{{ __('Hours') }}" />
                <x-jet-input id="hours" class="block mt-1 w-full" type="text" wire:model.defer="state.hours" />
                <x-jet-input-error for="hours" class="mt-2" />
            </div>
        </div>

        <div>
            <x-jet-label for="task" value="{{ __('Task') }}" />
            <x-jet-input id="task" class="block mt-1 w-full" type="text" wire:model.defer="state.task" />
            <x-jet-input-error for="task" class="mt-2" />
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
