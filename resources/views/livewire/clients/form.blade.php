<x-slideout max-width="4xl" wire:model="showModal">
    <x-slot name="title">
        {{ __(sprintf('%s Client', ucfirst($target))) }}
    </x-slot>

    <form class="space-y-4" wire:submit.prevent="{{ $target }}">
        <div>
            <x-jet-label for="company" value="{{ __('Company') }}" />
            <x-jet-input id="company" class="block mt-1 w-full" type="text" wire:model.defer="state.company" />
            <x-jet-input-error for="company" class="mt-2" />
        </div>

        <div>
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" class="block mt-1 w-full" type="text" wire:model.defer="state.name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" wire:model.defer="state.email" />
                <x-jet-input-error for="email" class="mt-2" />
            </div>

            <div>
                <x-jet-label for="phone" value="{{ __('Phone') }}" />
                <x-jet-input id="phone" class="block mt-1 w-full" type="text" wire:model.defer="state.phone" />
                <x-jet-input-error for="phone" class="mt-2" />
            </div>

            <div>
                <x-jet-label for="retainer" value="{{ __('Retainer Days') }}" />
                <x-jet-input id="retainer" class="block mt-1 w-full" type="text" wire:model.defer="state.retainer" />
                <x-jet-input-error for="retainer" class="mt-2" />
            </div>

            <div>
                <x-jet-label for="colour" value="{{ __('Colour') }}" />
                <x-jet-input id="colour" class="block mt-1 w-full" type="text" wire:model.defer="state.colour" />
                <x-jet-input-error for="colour" class="mt-2" />
            </div>

            <div class="col-span-full">
                <div class="flex items-center justify-between" x-data="{ on: @entangle('state.public_overview') }">
                    <input type="hidden" x-bind:value="on" wire:model="state.timer">

                    <span class="flex-grow flex flex-col">
                        <span class="text-sm font-medium text-gray-900" id="availability-label">{{ __('Public Overview') }}</span>
                        <span class="text-sm text-gray-500" id="availability-description">{{ __('Enabling this will generate a public URL for this client.') }}</span>
                    </span>

                    <button
                        type="button"
                        class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent bg-gray-200"
                        role="switch"
                        aria-checked="false"
                        x-ref="switch"
                        x-state:on="Enabled"
                        x-state:off="Not Enabled"
                        :class="{ 'bg-accent': on, 'bg-gray-200': !(on) }"
                        aria-labelledby="availability-label"
                        aria-describedby="availability-description"
                        :aria-checked="new Boolean(on).toString()"
                        @click="on = !on"
                    >
                        <span aria-hidden="true" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200 translate-x-0" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'translate-x-5': on, 'translate-x-0': !(on) }"></span>
                    </button>
                </div>
            </div>

            @if ($client?->uuid)
                <div>
                    <button type="button" data-clipboard-text="{{ route('clients.overview', $client->uuid) }}" class="clipboard inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-lg font-semibold text-xs text-gray-700 tracking-wide hover:bg-gray-700 hover:text-white active:bg-gray-900 active:text-white focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                        {{ __('Copy Overview URL') }}
                    </button>
                </div>
            @endif
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
