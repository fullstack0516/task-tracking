<div>
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('time-entries.index') }}
    </x-slot>

    @if (! $client)
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-card>
                <p class="text-sm">
                    {{ __('Create a client with a retainer to get started.') }}
                </p>
            </x-card>
        </div>
    @else
        @livewire('time-entries.form', ['client' => $client])

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h3 class="text-xs tracking-wide font-semibold uppercase text-gray-700 leading-tight">
                    {{ $currentDate->format('F Y') }} - {{ $client->company }}
                </h3>

                <div class="flex items-center space-x-2">
                    <button type="button" wire:click="prevMonth">
                        <x-heroicon-o-arrow-circle-left class="h-6 w-6 text-gray-400" />
                    </button>

                    <button type="button" wire:click="nextMonth">
                        <x-heroicon-o-arrow-circle-right class="h-6 w-6 text-gray-400" />
                    </button>

                    <button type="button" wire:click="export">
                        <x-heroicon-o-cloud-download class="w-6 h-6 text-gray-400" />
                    </button>

                    <button type="button" wire:click="$emit('toggleCreateTimeEntryModal')">
                        <x-heroicon-o-plus-circle class="w-6 h-6 text-gray-400" />
                    </button>
                </div>
            </div>

            <div class="mt-4 grid grid-cols-1 lg:grid-cols-12 gap-8">
                <div class="lg:col-span-3 order-1">
                    <x-card class="space-y-4">
                        <div>
                            <span class="text-xl font-semibold leading-5">{{ $timeUsedLastMonth }}</span>
                            <p class="text-sm text-gray-600">Days used last month</p>
                        </div>
                        <div>
                            <span class="text-xl font-semibold leading-5">{{ $timeUsedForMonth }}</span>
                            <p class="text-sm text-gray-600">Days used this month</p>
                        </div>
                        <div>
                            <span class="text-xl font-semibold leading-5">{{ $timeRemaining }}</span>
                            <p class="text-sm text-gray-600">Days remaining this month</p>
                        </div>
                        <div>
                            <span class="text-xl font-semibold leading-5">{{ $timeUsedToday }}</span>
                            <p class="text-sm text-gray-600">Time used today</p>
                        </div>
                    </x-card>
                </div>

                <div class="lg:col-span-6 order-3 lg:order-2">
                    <div class="space-y-4">
                        @forelse ($items as $item)
                            <x-card class="overflow-visible">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        @if ($item->user)
                                            <img class="h-8 w-8 rounded-full object-cover" src="{{ $item->user->profile_photo_url }}" alt="{{ $item->user->name }}">
                                        @else
                                            <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center">
                                                <x-heroicon-o-emoji-happy class="h-5 w-5 text-gray-600" />
                                            </div>
                                        @endif
                                        <div class="ml-3">
                                            <p class="text-sm leading-tight">{{ $item->user?->name ?: 'Manage' }}</p>
                                            <p class="text-xs text-gray-600 leading-tight">{{ $item->date }}</p>
                                        </div>
                                    </div>

                                    <x-jet-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            <span class="inline-flex rounded-md">
                                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                                    <x-heroicon-o-dots-vertical class="-mr-0.5 h-4 w-4" />
                                                </button>
                                            </span>
                                        </x-slot>

                                        <x-slot name="content">
                                            <x-jet-dropdown-link href="#!" wire:click="$emit('toggleEditTimeEntryModal', {{ $item->id }})">
                                                {{ __('Edit') }}
                                            </x-jet-dropdown-link>

                                            <x-jet-dropdown-link class="text-rose-600" href="#!" wire:click="deleteTimeEntry({{ $item->id }})">
                                                {{ __('Delete') }}
                                            </x-jet-dropdown-link>
                                        </x-slot>
                                    </x-jet-dropdown>
                                </div>

                                <div class="mt-6">
                                    <p class="text-sm text-gray-500">
                                        {{ __('Logged') }}
                                        <span class="font-medium text-gray-900">
                                            {{ $item->hours }} {{ __('hours') }}
                                        </span>
                                        @if ($item->task)
                                            {{ __('on the task') }}
                                            <span class="font-medium text-gray-900">
                                                {{ $item->task }}
                                            </span>
                                        @endif
                                    </p>

                                    @if ($item->note)
                                        <p class="mt-1 text-sm text-gray-500">{{ $item->note }}</p>
                                    @endif
                                </div>
                            </x-card>
                        @empty
                            <x-empty-card />
                        @endforelse
                    </div>
                </div>

                <div class="lg:col-span-3 order-2 lg:order-3">
                    <x-card>
                        <x-client.time-used />
                    </x-card>
                </div>
            </div>
        </div>
    @endif
</div>
