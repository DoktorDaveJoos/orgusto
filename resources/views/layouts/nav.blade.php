<nav class="flex justify-center @guest @else bg-gray-200 shadow-md sticky @endif top-0 z-50 h-20">

    <div class="max-w-6xl w-full flex flex-row justify-between content-center">

        <div class="flex flex-row items-center">
            <a href="@guest {{ route('home') }} @else {{ route('reservations.show') }} @endguest">
                <img class="w-32" src="{{ asset('orgusto-logo-svg.svg') }}"/>
            </a>
        </div>

        @guest
            <div class="flex flex-1 py-6 justify-end font-semibold">
                <a class="text-l text-gray-600 hover:text-indigo-600 mr-6 transition-colors duration-150 ease-in-out"
                   href="{{ route('login') }}">{{ __('auth.login') }}</a>
                <a class="text-l text-gray-600 hover:text-indigo-600 transition-colors duration-150 ease-in-out"
                   href="{{ route('register') }}">{{ __('auth.register') }}</a>
            </div>
        @else
            <div class="flex items-center">
                @if(auth()->user()->restaurants->count() > 1 || (!auth()->user()->selected && auth()->user()->restaurants->count() >= 1))
                    <x-restaurant-switcher></x-restaurant-switcher>
                @endif

                @if(auth()->user()->restaurants->count() >= 1)
                    <a href="{{ route('reservations.show') }}"
                       class="px-6 py-3 ml-6 flex flex-col justify-center text-gray-400 hover:text-gray-600 transition-colors duration-75 ease-in-out {{ request()->routeIs('reservations*') ? 'font-semibold text-indigo-600' : '' }}">
                        <i class="text-lg text-center far fa-calendar"></i>
                        <span class="text-xs pt-1">{{ __('nav.reservations') }}</span>
                    </a>

                    <a href="{{ route('manage.show') }}"
                       class="px-6 py-3 flex flex-col justify-center text-gray-400 hover:text-gray-600 transition-colors duration-75 ease-in-out {{ request()->routeIs('manage*') ? 'font-semibold text-indigo-600' : '' }}">
                        <i class="text-lg text-center fa fa-stream"></i>
                        <span class="text-xs pt-1">{{ __('nav.tables') }}</span>
                    </a>
                @endif

            </div>

            <div class="flex flex-row items-center">

                <div class="mx-auto text-right">

                    <div x-data="{ open: false }" @keydown.window.escape="open = false" @click.away="open = false"
                         class="relative inline-block text-left">
                        <div>
                            <button @click="open = !open" type="button"
                                    class="inline-flex items-center justify-center w-full px-4 py-4 text-sm font-medium text-gray-700 focus:outline-none"
                                    id="options-menu" aria-haspopup="true" aria-expanded="true"
                                    x-bind:aria-expanded="open">

                                <img class="w-8 mr-2" src="{{ asset('img/user-icon.svg') }}"/>
                                {{ Auth::user()->name }}
                                <svg class="-mr-1 ml-2 h-5 w-5" x-description="Heroicon name: solid/chevron-down"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>

                        <transition enter-active-class="transition ease-out duration-100"
                                    enter-class="transform opacity-0 scale-95"
                                    enter-to-class="transform opacity-100 scale-100"
                                    leave-active-class="transition ease-in duration-75"
                                    leave-class="transform opacity-100 scale-100"
                                    leave-to-class="transform opacity-0 scale-95">
                            <div x-show="open" x-description="Dropdown panel, show/hide based on dropdown state."
                                 class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                <div class="py-1" role="menu" aria-orientation="vertical"
                                     aria-labelledby="options-menu">

                                    <a href="{{ route('user.show', ['user' => auth()->user()->id ]) }}"
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                       role="menuitem">Profil</a>

                                    <a class="group block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                       href="{{ route('restaurants.show') }}">
                                        {{ __('nav.restaurants') }}
                                    </a>

                                    <a class="group block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                       href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          class="hidden">@csrf</form>
                                </div>
                            </div>
                        </transition>
                    </div>

                </div>
                @endguest
            </div>
    </div>
</nav>

@include('trial-banner')


