<nav class="flex items-center justify-between shadow-lg flex-wrap bg-gray-200 p-4 mb-2 sticky top-0 z-50">
  <div>
    <img class="w-40" src="{{ asset('orgusto-logo-svg.svg') }}" />
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
        <a class="p-2 text-center hover:text-blue-600 {{ request()->routeIs('home*') ? 'text-blue-600 font-semibold' : '' }}" href="{{ route('home') }}">{{ __('Home') }}</a>
        <a class="p-2 text-center hover:text-blue-600 {{ request()->routeIs('reservations*') ? 'text-blue-600 font-semibold' : '' }}" href="{{ route('reservations.show') }}">{{ __('Reservations') }}</a>
        <a class="p-2 text-center hover:text-blue-600 {{ request()->routeIs('manage*') ? 'text-blue-600 font-semibold' : '' }}" href="{{ route('manage.show') }}">{{ __('Tables') }}</a>
        <a class="p-2 text-center hover:text-blue-600 {{ request()->routeIs('restaurant*') ? 'text-blue-600 font-semibold' : '' }}" href="{{ route('restaurants.show') }}">{{ __('Restaurants') }}</a>
      </div>

      <div>
        <span class="text-gray-600 text-center hover:border-gray-600 pr-2">Hi, {{ Auth::user()->name }}</span>
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
</nav>
