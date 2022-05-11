<x-card>
    <form class="space-y-6" wire:submit.prevent="updatePreferences">
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-4">
                <div
                    class="flex items-center justify-between"
                    x-data="{ on: @entangle('state.dark_mode') }"
                    x-init="$watch('on', value => document.getElementsByTagName('html')[0].classList = value ? 'dark' : 'light')"
                >
                    <input type="hidden" x-bind:value="on" wire:model="state.timer">

                    <span class="flex-grow flex flex-col">
                        <span class="text-sm font-medium text-gray-900" id="availability-label">{{ __('Dark Mode') }}</span>
                        <span class="text-sm text-gray-500" id="availability-description">{{ __('Are you a night owl? Disable your kryptonite and use dark mode.') }}</span>
                    </span>

                    <button type="button" class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent bg-gray-200" role="switch" aria-checked="false" x-ref="switch" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'bg-accent': on, 'bg-gray-200': !(on) }" aria-labelledby="availability-label" aria-describedby="availability-description" :aria-checked="on.toString()" @click="on = !on">
                        <span aria-hidden="true" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200 translate-x-0" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'translate-x-5': on, 'translate-x-0': !(on) }"></span>
                    </button>
                </div>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <div class="flex items-center justify-between" x-data="{ on: @entangle('state.compact_mode') }">
                    <input type="hidden" x-bind:value="on" wire:model="state.timer">

                    <span class="flex-grow flex flex-col">
                        <span class="text-sm font-medium text-gray-900" id="availability-label">{{ __('Compact Mode') }}</span>
                        <span class="text-sm text-gray-500" id="availability-description">{{ __('Desire a cleaner interface with less going on? This option will help.') }}</span>
                    </span>

                    <button type="button" class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent bg-gray-200" role="switch" aria-checked="false" x-ref="switch" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'bg-accent': on, 'bg-gray-200': !(on) }" aria-labelledby="availability-label" aria-describedby="availability-description" :aria-checked="on.toString()" @click="on = !on">
                        <span aria-hidden="true" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200 translate-x-0" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'translate-x-5': on, 'translate-x-0': !(on) }"></span>
                    </button>
                </div>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <fieldset>
                    <legend class="block text-sm font-medium text-gray-700">
                        {{ __('Accent Colour') }}
                    </legend>

                    <div
                        class="mt-4 flex items-center space-x-3"
                        x-data="{ active: @entangle('state.colour') }"
                        x-init="$watch('active', value => document.getElementsByTagName('html')[0].setAttribute('data-accent', value))"
                    >
                        @foreach (config('mybusiness.accent_colours') as $key => $colour)
                            <label
                                class="-m-0.5 relative p-0.5 rounded-full flex items-center justify-center cursor-pointer focus:outline-none {{ "ring-$colour-500" }}"
                                :class="{
                                    'ring ring-offset-1': (active === '{{ $colour }}') && (active === '{{ $colour }}'),
                                    'ring-2': !(active === '{{ $colour }}') && (active === '{{ $colour }}'),
                                }"
                            >
                                <input type="radio" name="color-choice" x-model="active" value="{{ $colour }}" class="sr-only" aria-labelledby="color-choice-{{ $key }}-label">
                                <p id="color-choice-{{ $key }}-label" class="sr-only">{{ ucfirst($colour) }}</p>
                                <span aria-hidden="true" class="h-8 w-8 {{ "bg-$colour-500" }} border border-black border-opacity-10 rounded-full"></span>
                            </label>
                        @endforeach
                    </div>
                </fieldset>
            </div>
        </div>

        <div class="flex items-center">
            <x-jet-button>
                {{ __('Save') }}
            </x-jet-button>

            <x-jet-action-message class="ml-3" on="saved">
                {{ __('Saved.') }}
            </x-jet-action-message>
        </div>
    </form>
</x-card>
