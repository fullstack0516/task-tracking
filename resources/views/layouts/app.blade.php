<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-accent="{{ auth()->user()->colour }}" class="{{ auth()->user()->theme === 'dark' ? 'dark' : 'light' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Icons -->
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    </head>
    <body class="bg-gray-100 dark:bg-gray-900 font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen">
            <div x-data="{ open: false }" @keydown.window.escape="open = false">
                @livewire('navigation-menu')

                <x-sidebar />

                <div class="{{ auth()->user()->compact ? 'lg:pl-20' : 'lg:pl-48' }} flex flex-col">
                    <div class="max-w-7xl mx-auto w-full p-4 sm:p-6 lg:p-8" id="header">
                        <div class="sticky top-0 z-10 flex-shrink-0 flex items-center h-16 rounded-lg bg-white dark:bg-gray-800 shadow">
                            <div class="flex-1 px-4 sm:px-6 flex justify-between">
                                <button type="button" class="mr-6 p-2 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 lg:hidden" @click="open = true">
                                    <span class="sr-only">{{ __('Open sidebar') }}</span>
                                    <x-heroicon-o-menu-alt-2 class="h-6 w-6" />
                                </button>

                                <div class="flex-1 flex">
                                    @if (isset($breadcrumbs))
                                        <div class="flex justify-between items-center space-x-4">
                                            {{ $breadcrumbs }}

                                            @if (isset($actions))
                                                {{ $actions }}
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <div class="ml-4 flex items-center md:ml-6">
                                    <div class="ml-3 relative">
                                        <x-jet-dropdown align="right" width="48">
                                            <x-slot name="trigger">
                                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                                    <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                                    </button>
                                                @else
                                                    <span class="inline-flex rounded-md">
                                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                                            {{ Auth::user()->name }}

                                                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                    </span>
                                                @endif
                                            </x-slot>

                                            <x-slot name="content">
                                                <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                                    {{ __('Account') }}
                                                </x-jet-dropdown-link>

                                                <x-jet-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam) }}">
                                                    {{ __('Teams') }}
                                                </x-jet-dropdown-link>

                                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                                    <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                                        {{ __('API Tokens') }}
                                                    </x-jet-dropdown-link>
                                                @endif

                                                <!-- Authentication -->
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf

                                                    <x-jet-dropdown-link href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                                        {{ __('Log Out') }}
                                                    </x-jet-dropdown-link>
                                                </form>
                                            </x-slot>
                                        </x-jet-dropdown>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Page Content -->
                    <main class="flex-1">
                        <div class="pt-4 pb-8 md:pt-0 md:pb-12">
                            {{ $slot }}
                        </div>
                    </main>
                </div>
            </div>
        </div>

        @stack('modals')
        @livewire('command-console')

        @livewireScripts
        <script src="{{ asset('js/editor.js') }}"></script>
        <script src="{{ asset('js/sortable.js') }}"></script>
    </body>
</html>
