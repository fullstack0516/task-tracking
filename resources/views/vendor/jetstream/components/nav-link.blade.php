@props(['active', 'icon', 'name'])

@php
$classes = ($active ?? false)
            ? 'bg-gray-100 text-accent flex-shrink-0 px-2.5 py-2 w-full inline-flex items-center rounded-lg transition'
            : 'text-gray-700 hover:bg-gray-100 flex-shrink-0 px-2.5 py-2 w-full inline-flex items-center rounded-lg transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <x-dynamic-component :component="'heroicon-o-'.$icon" class="h-6 w-6 text-accent" />
    <span class="ml-3 text-sm font-medium">{{ $name }}</span>
</a>
