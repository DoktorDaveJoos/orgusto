<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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

        <nav class="flex items-center justify-between flex-wrap bg-gray-200 p-3 shadow-md mb-2 sticky top-0">

            <div>
                <span class="font-display text-xl text-gray-600 pl-4 text-center">{{ ucfirst(config('app.name')) }}</span>
            </div>

            <div class="pr-4">
                <span class="text-gray-600 text-center hover:border-gray-600 pr-2">{{ Auth::user()->name }}</span>
                <a class="fas fa-sign-out-alt text-gray-600" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt text-gray-600"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </nav>


        <div class="flex flex-col justify-around">

            @foreach ($reservations as $reservation)

            <div class="shadow-md mb-2 mt-2 rounded-lg hover:shadow-xl w-8/12 self-center">

                <div class="w-full bg-gray-200 p-3 flex justify-between rounded-t-lg">

                    <div class="inline-block font-bold text-sm text-gray-700">
                        <i class="fas fa-clock"></i>
                        {{ date('h:m l', strtotime($reservation->starting_at)) }}
                    </div>
                    <div>
                        <button class="rounded-full bg-gray-600 text-white px-2 self-end hover:bg-green-600 mr-2 focus:no-underline focus:bg-green-400 focus:outline-none focus:shadow-outline">
                            <i class="fas fa-edit"></i>
                            edit
                        </button>
                        <button class="rounded-full bg-gray-600 text-white px-2 self-end hover:bg-red-600 focus:no-underline focus:bg-red-400 focus:outline-none focus:shadow-outline">
                            <i class="fas fa-trash-alt"></i>
                            delete
                        </button>
                    </div>
                </div>

                <div class="p-2">

                    <div class="text-xl text-gray-700 mb-2">{{ $reservation->name }}</div>
                    <div class="text-gray-700 text-base mb-2">
                        {{ $reservation->notice }}
                    </div>
                    <div class="py-2">
                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">
                            {{ $reservation->accepted_from }}
                        </span>
                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">
                            <i class="fas fa-hourglass"></i>
                            {{ $reservation->length }}h
                        </span>
                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">
                            <i class="fas fa-user-friends"></i>
                            {{ $reservation->person_count }} Persons
                        </span>
                    </div>
                </div>


            </div>


            @endforeach

            <div class="flex flex-col justify-around">

                {{ $reservations->links() }}

            </div>
        </div>


    </div>











</body>

</html>