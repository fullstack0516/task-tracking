@php($compact = auth()->user()->compact ?? false)

{{-- Static sidebar for desktop --}}
<div class="hidden lg:flex {{ $compact ? 'lg:w-20' : 'lg:w-48' }} lg:flex-col lg:fixed lg:inset-y-0">
    <div class="flex-1 flex flex-col min-h-0 bg-white dark:bg-gray-800 dark:border-gray-600">
        <div class="flex-1 flex flex-col overflow-y-auto">
            <nav class="flex flex-col items-center flex-1 px-2 py-4 space-y-1">
                @foreach (config('mybusiness.menu_items') as $routeName => $menuItem)
                    @if ($compact)
                        <x-compact-nav-link
                            href="{{ route($routeName) }}"
                            :active="request()->routeIs($routeName)"
                            :icon="$menuItem['icon']"
                            :name="__($menuItem['name'])"
                        />
                    @else
                        <x-jet-nav-link
                            href="{{ route($routeName) }}"
                            :active="request()->routeIs($routeName)"
                            :icon="$menuItem['icon']"
                            :name="__($menuItem['name'])"
                        />
                    @endif
                @endforeach
            </nav>
        </div>
    </div>
</div>
