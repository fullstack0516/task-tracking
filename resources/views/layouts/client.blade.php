<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
            <div class="flex flex-col">
                <div class="max-w-7xl mx-auto w-full p-4 sm:p-6 lg:p-8">
                    <div class="sticky top-0 z-10 flex-shrink-0 flex items-center h-16 rounded-lg bg-white dark:bg-gray-800 shadow">
                        <div class="flex-1 px-4 flex justify-between">
                            <button type="button" class="mr-6 p-2 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 lg:hidden" @click="open = true">
                                <span class="sr-only">{{ __('Open sidebar') }}</span>
                                <x-heroicon-o-menu-alt-2 class="h-6 w-6" />
                            </button>

                            <div class="flex-1 flex">
                                <div class="flex justify-between items-center space-x-4">
                                    <span class="text-sm font-medium text-gray-500 dark:text-white">
                                        {{ $header ?? 'Welcome!' }}
                                    </span>
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

        @livewireScripts
    </body>
</html>
