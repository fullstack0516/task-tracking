@props(['item'])

<div>
    <p class="text-sm text-gray-500 dark:text-white">
        {{ ucfirst($item->description) }}
        {{ __('project') }}
        @if (isset($item->getExtraProperty('attributes')['name']))
            <a href="{{ route('projects.overview', $item->subject_id) }}" class="font-medium text-gray-900 dark:text-white">{{ $item->getExtraProperty('attributes')['name'] }}</a>
        @elseif (isset($item->getExtraProperty('old')['name']))
            <span class="font-medium text-gray-900 dark:text-white">{{ $item->getExtraProperty('old')['name'] }}</span>
        @else
            <a href="{{ route('projects.overview', $item->subject_id) }}" class="font-medium text-gray-900 dark:text-white">{{ $item->subject->name }}</a>
        @endif
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
