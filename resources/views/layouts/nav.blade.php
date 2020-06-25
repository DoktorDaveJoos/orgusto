<nav class="flex justify-center shadow-lg bg-gray-200 sticky top-0 z-50">
  <div class="max-w-6xl w-full flex flex-row justify-between p-4 content-center">
    <div>
      <img class="w-32" src="{{ asset('orgusto-logo-svg.svg') }}" />
    </div>
    <div class="flex-1 flex flex-row items-center">

      @guest
      <div class="flex flex-1 justify-end">
        <a class="text-sm text-gray-600 hover:text-gray-700 mr-6" href="{{ route('login') }}">{{ __('Login') }}</a>
        @if (Route::has('register'))
        <a class="text-sm text-gray-600 hover:text-gray-700" href="{{ route('register') }}">{{ __('Register') }}</a>
      </div>
      @endif

      @else
      <div class="flex flex-1 justify-between items-center">

        <div class="flex-1 flex justify-center text-gray-600">
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
  </div>
</nav>
