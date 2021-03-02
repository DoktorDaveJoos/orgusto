<nav class="flex justify-center @guest @else bg-gray-200 shadow-md sticky @endif top-0 z-50">
    <div class="max-w-6xl w-full flex flex-row justify-between p-2 content-center">
        <div class="flex flex-col items-center">
            <a href="@guest {{  route('home') }} @else {{ route('reservations.show') }} @endguest">
                <img class="w-32" src="{{ asset('orgusto-logo-svg.svg') }}"/>
                <span class="text-xs text-gray-600 text-italic">{{ config('app.version') }} - free premium</span>
            </a>
        </div>
        <div class="flex-1 flex flex-row items-center">

            @guest
                <div class="flex flex-1 justify-end font-semibold">
                    <a class="text-l text-gray-600 hover:text-indigo-600 mr-6 transition-colors duration-150 ease-in-out"
                       href="{{ route('login') }}">{{ __('auth.login') }}</a>
                    <a class="text-l text-gray-600 hover:text-indigo-600 transition-colors duration-150 ease-in-out"
                       href="{{ route('register') }}">{{ __('auth.register') }}</a>
                </div>
            @else
                <div class="flex flex-1 justify-between items-center">

                    <div class="flex-1 flex justify-center text-gray-600">

                        <a href="{{ route('reservations.show') }}"
                           class="px-4 flex flex-col justify-center text-gray-400 hover:text-gray-600 transition-colors duration-75 ease-in-out {{ request()->routeIs('reservations*') ? 'font-semibold text-gray-800' : '' }}">
                            <i class="text-lg text-center far fa-calendar"></i>
                            <span class="text-xs pt-1">{{ __('nav.reservations') }}</span>
                        </a>
                        <a href="{{ route('manage.show') }}"
                           class="px-4 flex flex-col justify-center text-gray-400 hover:text-gray-600 transition-colors duration-75 ease-in-out {{ request()->routeIs('manage*') ? 'font-semibold text-gray-800' : '' }}">
                            <i class="text-lg text-center fa fa-stream"></i>
                            <span class="text-xs pt-1">{{ __('nav.tables') }}</span>
                        </a>
                        <a href="{{ route('restaurants.show') }}"
                           class="px-4 flex flex-col justify-center text-gray-400 hover:text-gray-600 transition-colors duration-75 ease-in-out {{ request()->routeIs('restaurant*') ? 'font-semibold text-gray-800' : '' }}">
                            <i class="text-lg text-center fas fa-store-alt"></i>
                            <span class="text-xs pt-1">{{ __('nav.restaurants') }}</span>
                        </a>

                    </div>
                    <div class="flex flex-shrink items-center">
                        <a href="{{ route('user.show', ['user' => auth()->user()->id ]) }}"
                           class="group flex flex-row justify-between items-center rounded-md p-2 mr-6">
                            <img class="w-8 mr-2" src="{{ asset('img/user-icon.svg') }}"/>
                            <span
                                class="group-hover:text-indigo-600 text-gray-600 text-center hover:border-gray-600 pr-2">
                                Hi, {{ Auth::user()->name }}!
                            </span>
                        </a>

                        <a class="group" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                            <span class="group-hover:text-indigo-600 text-gray-600 pr-1">Logout</span>
                            <i class="fas fa-sign-out-alt text-gray-600 group-hover:text-indigo-600"></i>
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

