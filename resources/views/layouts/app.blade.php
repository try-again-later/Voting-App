<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 text-gray-900">
            <header class="flex gap-2 items-center px-8 py-4">
                <a href="/" class="font-bold text-xl hover:underline flex gap-4">
                    <img src="{{ asset('img/logo.svg') }}" alt="App Logo" class="w-8 h-8">
                    <span>Voting App</span>
                </a>

                <div class="ml-auto flex gap-4">
                    @auth
                        <form method="post" action="{{ route('logout') }}" class="flex items-center">
                            @csrf

                            <button type="submit">{{ __('Log Out') }}</button>
                        </form>

                        <a href="#">
                            <img src="https://gravatar.com/avatar/0?d=mp" alt="Avatar" class="w-10 h-10 rounded-full" />
                        </a>
                    @else
                        <a href="{{ route('login') }}">{{ __('Log In') }}</a>
                        <a href="{{ route('register') }}">{{ __('Register') }}</a>
                    @endauth
                </div>
            </header>

            <main class="container m-auto px-8 py-4 text-gray-700">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
