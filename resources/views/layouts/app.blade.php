<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="flex items-center justify-between flex-wrap bg-gray-200 p-3 shadow-md mb-2 sticky top-0 z-50">
            <div>
                <span class="font-display text-xl text-gray-700 pl-4 text-center">{{ ucfirst(config('app.name')) }}</span>
            </div>
            <div class="pr-4 w-10/12">
                @guest
                <a class="text-sm text-gray-600 hover:text-gray-700 mr-6" href="{{ route('login') }}">{{ __('Login') }}</a>
                @if (Route::has('register'))
                <a class="text-sm text-gray-600 hover:text-gray-700" href="{{ route('register') }}">{{ __('Register') }}</a>
                @endif
                @else

                <div class="w-full flex justify-between">

                    <div class="text-gray-600">
                        <a class="pr-4 hover:text-blue-600" href="{{ route('reservations.show') }}">{{ __('List') }}</a>
                        <a class="pr-4 hover:text-blue-600" href="{{ route('manage.show') }}">{{ __('Manage') }}</a>
                        <a class="pr-4 hover:text-blue-600" href="{{ route('restaurants.show') }}">{{ __('Restaurant') }}</a>
                    </div>

                    <div>
                        <span class="text-gray-600 text-center hover:border-gray-600 pr-2">{{ Auth::user()->name }}</span>
                        <a class="fas fa-sign-out-alt text-gray-600" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt text-gray-600"></i>
                        </a>
                    </div>

                </div>
                @endguest
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </nav>


        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
