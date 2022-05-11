<x-app-layout>
    <x-slot name="header">
        {{ __('Create Team') }}
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @livewire('teams.create-team-form')
    </div>
</x-app-layout>
