<x-card>
    <form class="space-y-6" wire:submit.prevent="updateProfileInformation">
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{ photoName: null, photoPreview: null }">
                <input
                    type="file"
                    class="hidden"
                    wire:model="photo"
                    x-ref="photo"
                    x-on:change="
                        photoName = $refs.photo.files[0].name;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            photoPreview = e.target.result;
                        };
                        reader.readAsDataURL($refs.photo.files[0]);
                    "
                />

                <x-jet-label for="photo" value="{{ __('Photo') }}" />

                <div class="mt-2 flex items-center space-x-8">
                    <div>
                        <!-- Current Profile Photo -->
                        <div x-show="! photoPreview">
                            <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover">
                        </div>

                        <!-- New Profile Photo Preview -->
                        <div x-show="photoPreview" style="display: none;">
                            <span
                                class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                                x-bind:style="'background-image: url(\'' + photoPreview + '\');'"
                            ></span>
                        </div>
                    </div>

                    <div class="flex space-x-6 items-center">
                        <x-jet-secondary-button type="button" x-on:click.prevent="$refs.photo.click()">
                            {{ __('Change') }}
                        </x-jet-secondary-button>

                        @if ($this->user->profile_photo_path)
                            <button type="button" wire:click="deleteProfilePhoto" class="font-semibold text-xs text-gray-700 tracking-wide">
                                {{ __('Remove') }}
                            </button>
                        @endif
                    </div>
                </div>

                <x-jet-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autocomplete="name" />
                <x-jet-input-error for="name" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
                <x-jet-input-error for="email" class="mt-2" />
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
