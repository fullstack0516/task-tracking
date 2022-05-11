@props(['item'])

<div>
    <p class="text-sm text-gray-500 dark:text-white">
        {{ ucfirst($item->description) }}
        {{ __('time entry of') }}
        @if (isset($item->getExtraProperty('attributes')['hours']))
            <a href="{{ route('time-entries.index', ['client' => $item->subject->client->id]) }}" class="font-medium text-gray-900 dark:text-white">
                {{ $item->getExtraProperty('attributes')['hours'] }}
                {{ __('hours') }}
            </a>
        @elseif (isset($item->getExtraProperty('old')['hours']))
            <span class="font-medium text-gray-900 dark:text-white">
                {{ $item->getExtraProperty('old')['hours'] }}
                {{ __('hours') }}
            </span>
        @else
            <a href="{{ route('time-entries.index', ['client' => $item->subject->client->id]) }}" class="font-medium text-gray-900 dark:text-white">
                {{ $item->subject->hours }}
                {{ __('hours') }}
            </a>
        @endif
        {{ __('for client') }}
        <span class="font-medium text-gray-900 dark:text-white">
            {{ $item->subject->client->company }}
        </span>
    </p>

    @if ($item->description !== 'deleted' && $changes = $item->getExtraProperty('old'))
        <ul class="mt-1 text-xs text-gray-500 dark:text-white">
            @foreach ($changes as $key => $value)
                <li>
                    {{ $value ? __('Changed') : __('Updated') }}
                    <span>{{ str_replace('_', ' ', $key) }}</span>
                    @if ($value)
                        {{ __('from') }}
                        <span>{{ $value }}</span>
                    @endif
                    {{ __('to') }}
                    <span>{{ $item->getExtraProperty('attributes')[$key] }}</span>
                </li>
            @endforeach
        </ul>
    @endif
</div>
