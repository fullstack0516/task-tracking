<x-app-layout>
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('profile.show') }}
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ tab: 'profile' }">
        <nav class="mb-8 flex flex-col md:flex-row items-start space-y-4 md:space-x-4 md:space-y-0" aria-label="Tabs">
            <button type="button" x-on:click="tab = 'profile'" x-bind:class="tab === 'profile' ? 'bg-gray-200 text-gray-800' : 'text-gray-600 hover:text-gray-800'" class="px-3 py-2 font-medium text-sm rounded-md" aria-current="page">
                Profile
            </a>
            <button type="button" x-on:click="tab = 'password'" x-bind:class="tab === 'password' ? 'bg-gray-200 text-gray-800' : 'text-gray-600 hover:text-gray-800'" class="px-3 py-2 font-medium text-sm rounded-md" x-state:on="Current" x-state:off="Default">
                Password
            </a>
            <button type="button" x-on:click="tab = 'two-factor'" x-bind:class="tab === 'two-factor' ? 'bg-gray-200 text-gray-800' : 'text-gray-600 hover:text-gray-800'" class="px-3 py-2 font-medium text-sm rounded-md" x-state:on="Current" x-state:off="Default">
                Two Factor
            </a>
            <button type="button" x-on:click="tab = 'sessions'" x-bind:class="tab === 'sessions' ? 'bg-gray-200 text-gray-800' : 'text-gray-600 hover:text-gray-800'" class="px-3 py-2 font-medium text-sm rounded-md" x-state:on="Current" x-state:off="Default">
                Sessions
            </a>
            <button type="button" x-on:click="tab = 'settings'" x-bind:class="tab === 'settings' ? 'bg-gray-200 text-gray-800' : 'text-gray-600 hover:text-gray-800'" class="px-3 py-2 font-medium text-sm rounded-md">
                Settings
            </a>
        </nav>

        <div x-show="tab === 'profile'">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')
            @endif
        </div>

        <div x-show="tab === 'password'">
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                @livewire('profile.update-password-form')
            @endif
        </div>

        <div x-show="tab === 'two-factor'">
            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                @livewire('profile.two-factor-authentication-form')
            @endif
        </div>

        <div x-show="tab === 'sessions'">
            @livewire('profile.logout-other-browser-sessions-form')
        </div>

        <div class="space-y-12" x-show="tab === 'settings'">
            @livewire('profile.update-preferences')

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                @livewire('profile.delete-user-form')
            @endif
        </div>
    </div>
</x-app-layout>
