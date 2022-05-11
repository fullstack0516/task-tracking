@props(['item'])

<div>
    @if (! $item->description === 'created')
        <p class="text-sm text-gray-500 dark:text-white">
            {{ __('This state has not yet been implemented') }}
        </p>
    @else
        <p class="text-sm text-gray-500 dark:text-white">
            {{ __('Created a retainer consisting of') }}
            <span class="font-medium text-gray-900 dark:text-white">{{ $days = $item->getExtraProperty('attributes')['days'] }}</span>
            {{ $days === 1 ? __('day, starting on') : __('days, starting on') }}
            <span class="font-medium text-gray-900 dark:text-white">{{ now()->parse($item->getExtraProperty('attributes')['starts_at'])->format('Y-m-d') }}</span>
            {{ __('and ending on') }}
            <span class="font-medium text-gray-900 dark:text-white">{{ now()->parse($item->getExtraProperty('attributes')['ends_at'])->format('Y-m-d') }}</span>
        </p>
    @endif
</div>
