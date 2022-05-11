@props(['id', 'maxWidth'])

@php
$id = $id ?? md5($attributes->wire('model'));

$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
    '4xl' => 'sm:max-w-4xl',
][$maxWidth ?? '2xl'];
@endphp

<div
    x-data="{ show: @entangle($attributes->wire('model')).defer }"
    @keydown.window.escape="show = false"
    x-show="show"
    class="fixed inset-0 overflow-hidden z-50"
    aria-labelledby="slide-over-title"
    x-ref="dialog"
    aria-modal="true"
    style="display: none;"
>
    <div class="absolute inset-0 overflow-hidden">
        <div
            x-show="show"
            class="fixed inset-0 transform transition-all"
            x-on:click="show = false"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        >
            <div class="absolute inset-0 bg-gray-800 opacity-50"></div>
        </div>

        <div class="pointer-events-none fixed inset-y-0 left-0 right-0 flex max-w-full md:left-auto md:pl-10">
            <div
                x-show="show"
                x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                x-transition:enter-start="translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
                class="relative pointer-events-auto w-screen max-w-xl"
            >
                <div class="flex h-full flex-col overflow-y-auto bg-white pt-6 shadow-xl">
                    <div class="px-4 sm:px-6">
                        <div class="flex items-start justify-between">
                            <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">
                                {{ $title ?? '' }}
                            </h2>

                            <div class="ml-3 flex h-7 items-center">
                                <button type="button" class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" @click="show = false">
                                    <span class="sr-only">{{ __('Close panel') }}</span>
                                    <x-heroicon-o-x class="w-6 h-6" aria-hidden="true" />
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="relative mt-6 flex-1">
                        <div class="flex-grow px-4 sm:px-6 sm:pb-32">
                            {{ $slot }}
                        </div>
                    </div>
                </div>

                @if ($actions ?? false)
                    <div class="absolute bottom-0 left-0 right-0 bg-gray-100 w-full p-8">
                        {{ $actions }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
