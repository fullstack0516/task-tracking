<div
    x-show="open"
    class="fixed inset-0 flex z-40 lg:hidden"
    x-ref="dialog"
    aria-modal="true"
    style="display: none;"
>
    <div
        x-show="open"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-600 bg-opacity-75"
        @click="open = false"
        aria-hidden="true"style="display: none;"
    ></div>

    <div
        x-show="open"
        x-transition:enter="transition ease-in-out duration-300 transform"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in-out duration-300 transform"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="relative flex-1 flex flex-col max-w-xs w-full pt-4 pb-4 bg-white"
        style="display: none;"
    >
        <div
            x-show="open"
            x-transition:enter="ease-in-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in-out duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute top-0 right-0 -mr-12 pt-2"
            style="display: none;"
        >
            <button type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full object-cover focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="open = false">
                <span class="sr-only">{{ __('Close sidebar') }}</span>
                <x-heroicon-o-x class="h-6 w-6 text-white" />
            </button>
        </div>

        <div class="flex-1 h-0 overflow-y-auto">
            <nav class="px-2 space-y-1">
                @foreach (config('mybusiness.menu_items') as $routeName => $menuItem)
                    <x-jet-responsive-nav-link href="{{ route($routeName) }}" :active="request()->routeIs($routeName)">
                        <x-dynamic-component :component="'heroicon-o-'.$menuItem['icon']" class="h-6 w-6 mr-2" />
                        {{ __($menuItem['name']) }}
                    </x-jet-responsive-nav-link>
                @endforeach
            </nav>
        </div>
    </div>

    <div class="flex-shrink-0 w-14" aria-hidden="true">
        <!-- Dummy element to force sidebar to shrink to fit close icon -->
    </div>
</div>
