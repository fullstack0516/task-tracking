@props(['id', 'priority'])

@php
    $classes = 'bg-gray-100 text-gray-800';

    if ($priority === 'low') {
        $classes .= ' bg-green-100 text-green-800';
    } elseif ($priority === 'medium') {
        $classes .= ' bg-amber-100 text-amber-800';
    } elseif ($priority === 'high') {
        $classes .= ' bg-rose-100 text-rose-800';
    }
@endphp

<span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium {{ $classes }}">
    #{{ $id }}
</span>
