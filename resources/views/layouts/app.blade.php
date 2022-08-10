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

<body class="font-sans antialiased bg-gray-100 text-gray-900">
    <header class="container m-auto flex flex-wrap gap-2 items-center px-8 py-4 justify-center">
        <a href="/"
            class="font-bold text-xl hover:underline flex gap-4 w-full justify-center sm:justify-start sm:w-auto">
            <img src="{{ asset('img/logo.svg') }}" alt="App Logo" class="w-8 h-8">
            <span>Voting App</span>
        </a>

        <div class="sm:ml-auto flex gap-4">
            @auth
                <form method="post" action="{{ route('logout') }}" class="flex items-center">
                    @csrf

                    <button type="submit">{{ __('Log Out') }}</button>
                </form>

                <a href="#">
                    <img src="https://gravatar.com/avatar/0?d=mp" alt="Avatar" class="w-10 h-10 rounded-full" />
                </a>
            @else
                <a href="{{ route('login') }}" class="hover:underline text-lg">{{ __('Log In') }}</a>
                <a href="{{ route('register') }}" class="hover:underline text-lg">{{ __('Register') }}</a>
            @endauth
        </div>
    </header>

    <main class="container m-auto px-4 sm:px-8 py-4 text-gray-700">

        <h1 class="sr-only">Voting App</h1>

        <div class="flex flex-col gap-8 lg:flex-row lg:gap-0 lg:items-start">
            <section class="max-w-xs bg-white border-2 border-gray-200 rounded-xl px-4 py-6 m-auto lg:m-0">
                <h2 class="text-center font-semibold text-xl mb-2">Add an idea</h2>
                <p class="text-sm text-center mb-8">
                    Let us know what you would like and we'll take a look over!
                </p>
                <x-ideas.add-new-form />
            </section>

            <section class="flex-1 lg:pl-8">
                <h2 class="sr-only">Ideas</h2>

                <div class="flex flex-wrap gap-y-4 justify-center xl:justify-start w-full mb-8">
                    <x-ideas.filter-item :active="true" href="#" :first="true">
                        All ideas (89)
                    </x-ideas.filter-item>
                    <x-ideas.filter-item href="#">
                        Considering (6)
                    </x-ideas.filter-item>
                    <x-ideas.filter-item href="#" :last="true">
                        In progress (1)
                    </x-ideas.filter-item>

                    <x-ideas.filter-item class="xl:ml-auto" href="#" :first="true">
                        Implemented (10)
                    </x-ideas.filter-item>
                    <x-ideas.filter-item href="#" :last="true">
                        Closed (55)
                    </x-ideas.filter-item>
                </div>

                {{ $slot }}

            </section>
        </div>
    </main>
</body>

</html>
