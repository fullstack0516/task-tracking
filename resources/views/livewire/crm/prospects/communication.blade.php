<div>
    <form wire:submit.prevent="submit" class="grid grid-cols-4 gap-4 items-start">
       <div class="col-span-2">
            <x-jet-label for="state.description" value="{{ __('Description') }}" />
            <x-jet-input id="state.description" class="block mt-1 w-full" type="text" wire:model.defer="state.description" />
            <x-jet-input-error for="description" class="mt-2" />
        </div>

        <div>
            <x-jet-label for="state.type" value="{{ __('Type') }}" />
            <x-select id="state.type" class="block mt-1 w-full" type="text" wire:model.defer="state.type">
                <option value="">{{ __('Select an option') }}</option>
                @foreach (['email', 'phone', 'irl', 'other'] as $type)
                    <option value="{{ $type }}">{{ ucwords($type) }}</option>
                @endforeach
            </x-select>
            <x-jet-input-error for="type" class="mt-2" />
        </div>

        <div>
            <label class="block font-medium text-sm text-gray-700">
                &nbsp;
            </label>
            <x-jet-button class="mt-1 block w-full h-10 justify-center">
                {{ __('Add') }}
            </x-jet-button>
        </div>
    </form>

    <div class="mt-6 divide-y space-y-4">
        @forelse ($prospect->communications as $communication)
            <div class="grid grid-cols-4 gap-4 pt-4">
                <div class="col-span-2">
                    {{ $communication->description }}
                </div>
                <div>
                    {{ $communication->created_at }}
                </div>
                <div>
                    {{ ucwords($communication->type) }}
                </div>
            </div>
        @empty
            <p class="text-sm">
                {{ __('No results found') }}
            </p>
        @endforelse
    </div>
</div>
