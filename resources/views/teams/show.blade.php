<x-app-layout>
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('teams.show', $team) }}
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ tab: 'teams' }">
        <nav class="mb-8 flex flex-col md:flex-row items-start space-y-4 md:space-x-4 md:space-y-0" aria-label="Tabs">
            <button type="button" x-on:click="tab = 'teams'" x-bind:class="tab === 'teams' ? 'bg-gray-200 text-gray-800' : 'text-gray-600 hover:text-gray-800'" class="px-3 py-2 font-medium text-sm rounded-md" aria-current="page">
                Teams
            </a>
            <button type="button" x-on:click="tab = 'profile'" x-bind:class="tab === 'profile' ? 'bg-gray-200 text-gray-800' : 'text-gray-600 hover:text-gray-800'" class="px-3 py-2 font-medium text-sm rounded-md" x-state:on="Current" x-state:off="Default">
                Profile
            </a>
            <button type="button" x-on:click="tab = 'members'" x-bind:class="tab === 'members' ? 'bg-gray-200 text-gray-800' : 'text-gray-600 hover:text-gray-800'" class="px-3 py-2 font-medium text-sm rounded-md" x-state:on="Current" x-state:off="Default">
                Members
            </a>
            <button type="button" x-on:click="tab = 'settings'" x-bind:class="tab === 'settings' ? 'bg-gray-200 text-gray-800' : 'text-gray-600 hover:text-gray-800'" class="px-3 py-2 font-medium text-sm rounded-md">
                Settings
            </a>
        </nav>

        <div x-show="tab === 'teams'">
            @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <x-card>
                    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach (Auth::user()->allTeams() as $team)
                            <div>
                                <div class="p-6 bg-gray-50 rounded-lg">
                                    <div class="w-full flex items-center justify-between">
                                        <p class="text-sm font-medium text-gray-800">{{ $team->name }}</p>

                                        <div class="flex space-x-6 items-center">
                                            @if ($team->id === Auth::user()->currentTeam->id)
                                                <span class="font-semibold text-xs text-gray-700 tracking-wide">
                                                    {{ __('Current') }}
                                                </span>
                                            @else
                                                <button type="button" class="font-semibold text-xs text-indigo-700 tracking-wide" onclick="event.preventDefault(); document.getElementById('team-form-{{ $team->id }}').submit();">
                                                    {{ __('Switch') }}
                                                </button>
                                            @endif

                                            <a href="{{ route('teams.show', $team) }}" class="font-semibold text-xs text-indigo-700 tracking-wide">
                                                {{ __('Settings') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('current-team.update') }}" id="team-form-{{ $team->id }}">
                                    @method('PUT')
                                    @csrf

                                    <input type="hidden" name="team_id" value="{{ $team->id }}">
                                </form>
                            </div>
                        @endforeach

                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                            <a href="{{ route('teams.create') }}" class="p-6 bg-gray-50 rounded-md">
                                <div class="w-full flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-800">
                                        {{ __('Create New Team') }}
                                    </p>

                                    <x-heroicon-o-plus-circle class="h-6 w-6 text-gray-600" />
                                </div>
                            </a>
                        @endcan
                    </div>
                </x-card>
            @endif
        </div>

        <div x-show="tab === 'profile'" style="display: none;">
            @livewire('teams.update-team-name-form', ['team' => $team])
        </div>

        <div x-show="tab === 'members'" style="display: none;">
            @livewire('teams.team-member-manager', ['team' => $team])
        </div>

        <div x-show="tab === 'settings'" style="display: none;">
            @if (Gate::check('delete', $team) && ! $team->personal_team)
                @livewire('teams.delete-team-form', ['team' => $team])
            @endif
        </div>
    </div>
</x-app-layout>
