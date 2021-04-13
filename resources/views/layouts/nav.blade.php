@guest
    <nav class="flex justify-center top-0 z-50 h-20">

        <div class="max-w-6xl w-full flex flex-row justify-between content-center">

            <div class="flex flex-row items-center">
                <a href="{{ route('landing') }} ">
                    <img class="w-32" src="{{ asset('img/orgusto-logo-svg.svg') }}"/>
                </a>
            </div>

            <div class="flex flex-1 py-6 justify-end font-semibold">
                <a class="text-l text-gray-600 hover:text-indigo-600 mr-6 transition-colors duration-150 ease-in-out"
                   href="{{ route('login') }}">{{ __('auth.login') }}</a>
                <a class="text-l text-gray-600 hover:text-indigo-600 transition-colors duration-150 ease-in-out"
                   href="{{ route('register') }}">{{ __('auth.register') }}</a>
            </div>

        </div>

    </nav>
@endguest
