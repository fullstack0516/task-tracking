<x-slideout max-width="4xl" wire:model="showModal">
    <x-slot name="title">
        {{ __(sprintf('%s Project', ucfirst($target))) }}
    </x-slot>

    <form class="space-y-4" wire:submit.prevent="{{ $target }}">
        <div>
            <x-jet-label for="client_id" value="{{ __('Client') }}" />
            <x-select id="client_id" class="block mt-1 w-full" type="text" wire:model.defer="state.client_id">
                <option value="">{{ __('Select an option') }}</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->company }}</option>
                @endforeach
            </x-select>
            <x-jet-input-error for="client_id" class="mt-2" />
        </div>

        <div>
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" class="block mt-1 w-full" type="text" wire:model.defer="state.name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <div>
            <x-jet-label for="description" value="{{ __('Description') }}" />
            <x-textarea id="description" class="block mt-1 w-full" type="text" wire:model.defer="state.description" />
            <x-jet-input-error for="description" class="mt-2" />
        </div>

        <div>
            <x-jet-label for="repository_url" value="{{ __('Repository URL') }}" />
            <x-jet-input id="repository_url" class="block mt-1 w-full" type="text" wire:model.defer="state.repository_url" />
            <x-jet-input-error for="repository_url" class="mt-2" />
        </div>

        <div>
            <x-jet-label for="colour" value="{{ __('Colour') }}" />
            <x-jet-input id="colour" class="block mt-1 w-full" type="text" wire:model.defer="state.colour" />
            <x-jet-input-error for="colour" class="mt-2" />
        </div>

        <div>
            <label for="notifies_slack" class="flex items-center">
                <x-jet-checkbox id="notifies_slack" wire:model.defer="state.notifies_slack" />
                <span class="ml-2 text-sm text-gray-700 font-medium">{{ __('Notifies Slack') }}</span>
            </label>
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
