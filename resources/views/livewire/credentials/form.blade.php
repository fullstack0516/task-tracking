<x-slideout max-width="4xl" wire:model="showModal">
    <x-slot name="title">
        {{ __(sprintf('%s Credential', ucfirst($target))) }}
    </x-slot>

    <form class="space-y-4" wire:submit.prevent="{{ $target }}">
        <div>
            <x-jet-label for="service" value="{{ __('Service') }}" />
            <x-jet-input id="service" class="block mt-1 w-full" type="text" wire:model.defer="state.service" />
            <x-jet-input-error for="service" class="mt-2" />
        </div>
        <div>
            <x-jet-label for="email" value="{{ __('Email') }}" />
            <x-jet-input id="email" class="block mt-1 w-full" type="email" wire:model.defer="state.email" />
            <x-jet-input-error for="email" class="mt-2" />
        </div>

        <div>
            <x-jet-label for="user_id" value="{{ __('User') }}" />
            <x-select id="user_id" class="block mt-1 w-full" type="text" wire:model.defer="state.user_id">
                <option value="">{{ __('Select an option') }}</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </x-select>
            <x-jet-input-error for="user_id" class="mt-2" />
        </div>

        <div>
            <x-jet-label for="notes" value="{{ __('Notes') }}" />
            <x-textarea id="notes" class="block mt-1 w-full" type="text" wire:model.defer="state.notes" />
            <x-jet-input-error for="notes" class="mt-2" />
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
