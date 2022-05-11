<div>
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('clients.show', $client) }}
    </x-slot>

    <x-slot name="actions">
        <div class="flex items-center space-x-2">
            <x-link href="{{ route('clients.show', $client) }}">
                <x-heroicon-o-home class="w-6 h-6 text-gray-400" />
            </x-link>

            <x-link href="#!" x-on:click="Livewire.emit('toggleEditClientModal', {{ $client->id }})">
                <x-heroicon-o-cog class="w-6 h-6 text-gray-400" />
            </x-link>

            @if ($client->retainer)
                <x-link href="{{ route('time-entries.index', $client) }}">
                    <x-heroicon-o-clock class="w-6 h-6 text-gray-400" />
                </x-link>
            @endif
        </div>
    </x-slot>

    @livewire('clients.form')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-9">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    <div class="lg:col-span-3">
                        <x-card>
                            <div class="border-2 border-dashed rounded-lg h-full min-h-[18rem]"></div>
                        </x-card>
                    </div>

                    <div class="lg:col-span-9">
                        <x-card>
                            <div class="border-2 border-dashed rounded-lg h-full min-h-[18rem]"></div>
                        </x-card>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-3">
                <x-card>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                        {{ __('Retainer') }}
                    </h2>

                    @if ($client->retainer)
                        <div class="mt-4">
                            <x-client.time-used />
                        </div>
                    @endif
                </x-card>
            </div>
        </div>
    </div>
</div>
