@props(['active', 'icon', 'name'])

@php
$classes = ($active ?? false)
            ? 'bg-accent text-accent-contrast flex-shrink-0 inline-flex items-center justify-center h-12 w-12 rounded-lg transition'
            : 'text-accent opacity-50 hover:bg-accent hover:text-accent-contrast flex-shrink-0 inline-flex items-center justify-center h-12 w-12 rounded-lg transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <x-dynamic-component :component="'heroicon-o-'.$icon" class="h-6 w-6" />
    {{-- <span class="mt-2">{{ $name }}</span> --}}
</a>
