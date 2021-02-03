

<nav class="flex justify-center shadow-lg bg-gray-200 sticky top-0 z-50">
    <div class="max-w-6xl w-full flex flex-row justify-between p-2 content-center">
        <div class="flex flex-col items-center">
            <img class="w-32" src="{{ asset('orgusto-logo-svg.svg') }}"/>
            <span class="text-xs text-gray-600 text-italic">{{ config('app.version') }} - free premium</span>
        </div>
        <div class="flex-1 flex flex-row items-center">

            @guest
                <div class="flex flex-1 justify-end">
                    <a class="text-sm text-gray-600 hover:text-gray-700 mr-6"
                       href="{{ route('login') }}">{{ __('Login') }}</a>
                    @if (Route::has('register'))
                        <a class="text-sm text-gray-600 hover:text-gray-700"
                           href="{{ route('register') }}">{{ __('Register') }}</a>
                </div>
            @endif

            @else
                <div class="flex flex-1 justify-between items-center">

                    <div class="flex-1 flex justify-center text-gray-600">

                        <div id="navApp">
                            <global-create-reservation tables-endpoint="{{ route('tables.index') }}"
                                                       reservations-endpoint="{{ route('reservations.store') }}">
                            </global-create-reservation>
                        </div>

                        <a href="{{ route('reservations.show') }}"
                           class="px-4 flex flex-col justify-center text-gray-400 hover:text-gray-600 transition-colors duration-75 ease-in-out {{ request()->routeIs('reservations*') ? 'font-semibold text-gray-800' : '' }}">
                            <i class="text-lg text-center far fa-calendar"></i>
                            <span class="text-xs pt-1">{{ __('Reservations') }}</span>
                        </a>
                        <a href="{{ route('manage.show') }}"
                           class="px-4 flex flex-col justify-center text-gray-400 hover:text-gray-600 transition-colors duration-75 ease-in-out {{ request()->routeIs('manage*') ? 'font-semibold text-gray-800' : '' }}">
                            <i class="text-lg text-center fa fa-stream"></i>
                            <span class="text-xs pt-1">{{ __('Tables') }}</span>
                        </a>
                        <a href="{{ route('restaurants.show') }}"
                           class="px-4 flex flex-col justify-center text-gray-400 hover:text-gray-600 transition-colors duration-75 ease-in-out {{ request()->routeIs('restaurant*') ? 'font-semibold text-gray-800' : '' }}">
                            <i class="text-lg text-center fas fa-store-alt"></i>
                            <span class="text-xs pt-1">{{ __('Restaurants') }}</span>
                        </a>


                    </div>
                    <div>
                        <span
                            class="text-gray-600 text-center hover:border-gray-600 pr-2">Hi, {{ Auth::user()->name }}</span>
                        <a class="fas fa-sign-out-alt text-gray-600" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                        </a>
                    </div>
                </div>
            @endguest
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>
</nav>

