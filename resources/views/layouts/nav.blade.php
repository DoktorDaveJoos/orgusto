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
