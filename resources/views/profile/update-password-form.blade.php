<x-card>
    <form class="space-y-4" wire:submit.prevent="updatePassword">
        <div class="col-span-full">
            <x-jet-label for="current_password" value="{{ __('Current Password') }}" />
            <x-jet-input id="current_password" type="password" class="mt-1 block w-full" wire:model.defer="state.current_password" autocomplete="current-password" />
            <x-jet-input-error for="current_password" class="mt-2" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="col-span-full sm:col-span-1">
                <x-jet-label for="password" value="{{ __('New Password') }}" />
                <x-jet-input id="password" type="password" class="mt-1 block w-full" wire:model.defer="state.password" autocomplete="new-password" />
                <x-jet-input-error for="password" class="mt-2" />
            </div>

            <div class="col-span-full sm:col-span-1">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" type="password" class="mt-1 block w-full" wire:model.defer="state.password_confirmation" autocomplete="new-password" />
                <x-jet-input-error for="password_confirmation" class="mt-2" />
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
