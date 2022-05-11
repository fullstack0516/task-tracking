@props(['model', 'size'])

@php
    $sizeClasses = isset($size) && $size === 'small' ? 'w-8 h-8' : 'w-10 h-10';
    $textClasses = $model->colourBrightness > 5 ? 'text-gray-900' : 'text-white';
@endphp

<div {{ $attributes->merge(['class' => 'flex-shrink-0 text-xs font-semibold uppercase flex items-center justify-center rounded-lg '.$sizeClasses.' '.$textClasses]) }} style="background-color: {{ $model->colour }};">
    {{ $model->initials ?? '?' }}
</div>
