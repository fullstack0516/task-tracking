<div class="space-y-8">
    <x-card>
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                @if ($currentDate->isToday())
                    {{ __('Today') }}
                @elseif ($currentDate->isYesterday())
                    {{ __('Yesterday') }}
                @elseif ($currentDate->isTomorrow())
                    {{ __('Tomorrow') }}
                @else
                    {{ $currentDate->format('F j') }}
                @endif
            </h2>

            <div class="flex items-center space-x-2">
                <button type="button" wire:click="moveCalendarLeft" class="text-gray-300 hover:text-gray-700 transition">
                    <x-heroicon-o-arrow-circle-left class="h-6 w-6" />
                </button>

                <button type="button" wire:click="moveCalendarRight" class="text-gray-300 hover:text-gray-700 transition">
                    <x-heroicon-o-arrow-circle-right class="h-6 w-6" />
                </button>

                <button type="button" wire:click="$emit('toggleCreateEventModal', '{{ $currentDate }}')" class="text-gray-300 hover:text-gray-700 transition">
                    <x-heroicon-s-plus-circle class="h-6 w-6" />
                </button>
            </div>
        </div>

        <div class="mt-4 space-y-2">
            @forelse ($events as $event)
                <x-event.item :event="$event" />
            @empty
                @for ($i = 0; $i < 2; $i++)
                    <x-event.empty-item />
                @endfor
            @endforelse
        </div>
    </x-card>

    <x-card>
        <h2 class="text-lg font-medium text-gray-900 dark:text-white">
            {{ __('Upcoming') }}
        </h3>

        <div class="mt-4 space-y-2">
            @forelse ($upcomingEvents as $event)
                <x-event.item :event="$event" :show-date="true" />
            @empty
                @for ($i = 0; $i < 2; $i++)
                    <x-event.empty-item />
                @endfor
            @endforelse
        </div>
    </x-card>
</div>
