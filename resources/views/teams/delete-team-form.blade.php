<div>
    <x-card>
        <div class="max-w-2xl bg-rose-50/75 p-4 rounded-lg text-sm text-gray-800">
            {{ __('Once a team is deleted, all of its resources and data will be permanently deleted. Before deleting this team, please download any data or information regarding this team that you wish to retain.') }}
        </div>

        <div class="mt-5">
            <x-jet-danger-button wire:click="$toggle('confirmingTeamDeletion')" wire:loading.attr="disabled">
                {{ __('Delete Team') }}
            </x-jet-danger-button>
        </div>
    </x-card>

    <!-- Delete Team Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingTeamDeletion">
        <x-slot name="title">
            {{ __('Delete Team') }}
        </x-slot>

        <x-slot name="content">
            <p class="text-sm text-gray-800">
                {{ __('Are you sure you want to delete this team? Once a team is deleted, all of its resources and data will be permanently deleted.') }}
            </p>
        </x-slot>

        <x-slot name="footer">
            <x-jet-danger-button wire:click="deleteTeam" wire:loading.attr="disabled">
                {{ __('Delete Team') }}
            </x-jet-danger-button>

            <x-jet-secondary-button wire:click="$toggle('confirmingTeamDeletion')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
