<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        @livewireStyles
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tailwindcss/ui@latest/dist/tailwind-ui.min.css">
    </head>

    <body class="antialiased" style="background-image: url({{ url('img/Fondo.svg') }})">
        <div class="min-h-screen">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <div class="flex justify-center mt-12 mb-12">
                <div class="absolute w-full h-20 max-w-6xl px-4 py-6 rounded-t-3xl" style="background-color: #ff6751; z-index:-1"></div>
                <main class="w-full max-w-6xl px-4 py-6 mx-auto shadow-md rounded-3xl backdrop-blur-sm auto sm:px-6 lg:px-8">
                    {{ $slot }}
                </main>
            </div>

        </div>

        <x-footer/>

        @stack('modals')

        @livewireScripts

        <script src="{{ mix('js/app.js') }}"></script>
        <script src="{{ url('js/main.js') }}"></script>

        @stack('scripts')
    </body>
</html>
