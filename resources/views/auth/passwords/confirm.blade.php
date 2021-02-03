@extends('layouts.app')

@section('content')

    @infocard(['title' => __('Confirm Password')])

    <div class="text-gray-600 p-2 font-normal">
        {{ __('Please confirm your password before continuing.') }}

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            @forminput(['label' => 'password'])
            <input id="password" placeholder="{{ __('Password') }}" type="password"
                   class="orgusto-input form-control @error('password') is-invalid @enderror" name="password" required
                   autocomplete="current-password">
            @endforminput
            @error('password')
            <div class="flex text-red-600 text-italic text-sm mx-2">
                {{ $message  }}
            </div>
            @enderror

            <div class="w-full flex justify-between items-center mt-2 p-2">

                <button type="submit"
                        class="orgusto-button text-blue-600 hover:bg-blue-600 hover:text-white transition-colors duration-150 ease-in-out">
                    {{ __('Confirm Password') }}
                </button>

                @if (Route::has('password.request'))
                    <a class="text-sm hover:text-blue-400" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif

            </div>
        </form>
    </div>

    @endinforcard
@endsection
