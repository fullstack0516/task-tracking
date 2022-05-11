<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-accent="indigo" class="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>manage - mybusiness.</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col items-center justify-center">
            <div class="text-center">
                <h1 class="text-4xl text-indigo-600 font-bold">manage.</h1>
                <h2 class="mt-2 text-2xl text-gray-500 font-semibold">by Odelan.</h2>
            </div>

            @if (Route::has('login'))
                <div class="mt-6">
                    @auth
                        <x-link href="{{ url('/dashboard') }}">
                            {{ __('Dashboard') }}
                        </x-link>
                    @else
                        <x-link href="{{ route('login') }}">
                            {{ __('Log in') }}
                        </x-link>
                    @endauth
                </div>
            @endif
        </div>
    </body>
</html>
