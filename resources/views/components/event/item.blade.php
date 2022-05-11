@props(['event', 'showDate' => false])

@php
    $bgClasses = 'border-sky-500';

    if ($event->type === 'holiday') {
        $bgClasses = 'border-green-500';
    } elseif ($event->type === 'meeting') {
        $bgClasses = 'border-pink-500';
    } elseif ($event->type === 'sick') {
        $bgClasses = 'border-yellow-500';
    }
@endphp

<div class="relative px-3 py-0.5 border-l-2 {{ $bgClasses }} flex-grow min-w-[30%]">
    <div class="flex items-center justify-between">
        <p class="text-xs font-semibold tracking-wide leading-snug truncate">
            {{ ucfirst($event->type) }}
        </p>

        @if ($showDate)
            <p class="text-xs font-semibold tracking-wide leading-snug truncate">
                {{ $event->starts_at->format('Y-m-d') }}
            </p>
        @endif
    </div>

    <p class="mt-0.5 text-xs tracking-wide leading-snug text-gray-800 truncate">
        {{ $event->user->first_name }}
    </p>

    <a href="#!" wire:click="$emit('toggleEditEventModal', {{ $event->id }})" class="absolute inset-0 focus:z-10 focus:outline-none focus:ring-2 ring-indigo-400"></a>
</div>
