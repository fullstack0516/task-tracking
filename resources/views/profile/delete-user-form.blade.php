<div>
    <x-card>
        <div class="max-w-2xl bg-rose-50/75 p-4 rounded-lg text-sm text-gray-800">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </div>

        <div class="mt-5">
            <x-jet-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                {{ __('Delete Account') }}
            </x-jet-danger-button>
        </div>
    </x-card>

    <!-- Delete User Confirmation Modal -->
    <x-jet-dialog-modal maxWidth="xl" wire:model="confirmingUserDeletion">
        <x-slot name="title">
            {{ __('Delete Account') }}
        </x-slot>

        <x-slot name="content">
            <p class="text-sm text-gray-800">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
                <br><br>
                {{ __('Please enter your password one last time to confirm this action.') }}
            </p>

            <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                <x-jet-input type="password" class="mt-1 block w-3/4" placeholder="{{ __('Password') }}" x-ref="password" wire:model.defer="password" wire:keydown.enter="deleteUser" />
                <x-jet-input-error for="password" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-danger-button wire:click="deleteUser" wire:loading.attr="disabled">
                {{ __('Delete Account') }}
            </x-jet-danger-button>

            <x-jet-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
