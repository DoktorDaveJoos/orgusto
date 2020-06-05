@extends('layouts.app')

@section('content')


@infocard(['title' => __('Login')])

<div class="p-4 flex justify-center">

    <div class="w-full max-w-lg">

        <form method="POST" action="{{ route('login') }}">
            @csrf

            @forminput(['label' => 'email'])
            <input id="email" placeholder="{{ __('Email Adresse') }}" type="email" class="orgusto-input" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @endforminput

            @forminput(['label' => 'password'])
            <input id="password" placeholder="{{ __('Password') }}" type="password" class="orgusto-input" name="password" required autocomplete="current-password">
            @endforminput

            <div class="flex items-center p-2">
                <label class="text-gray-600 text-sm leading-tight mr-2" for="remember">
                    {{ __('Remember me') }}
                </label>
                <input class="self-center mr-2" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            </div>

            <div class="w-full flex justify-between items-center mt-2 p-2">
                <button type="submit" class="orgusto-button text-blue-600 hover:bg-blue-600 hover:text-white transition-colors duration-150 ease-in-out">
                    <i class="fas fa-sign-in-alt mr-2"></i>{{ __('Login') }}
                </button>

                @if (Route::has('password.request'))
                <a class="text-sm text-gray-600 hover:text-blue-400" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
                @endif
            </div>

        </form>
    </div>

</div>
@endinfocard



@endsection
