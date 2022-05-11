@props(['type'])

@php
    $classes = 'inline-flex items-center px-2 py-1 rounded-md text-xs font-medium';

    if ($type === 'story') {
        $classes .= ' bg-lime-200 bg-opacity-40 text-lime-800';
    } elseif ($type === 'task') {
        $classes .= ' bg-sky-200 bg-opacity-40 text-sky-800';
    } elseif ($type === 'bug') {
        $classes .= ' bg-rose-200 bg-opacity-40 text-rose-800';
    }
@endphp

<span class="{{ $classes }}">
    {{ ucfirst($type) }}
</span>
