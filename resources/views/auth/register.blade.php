@extends('layouts.app')

@section('content')

    @infocard(['title' => __('Register')])

    <div class="p-4 flex justify-center">

        <div class="w-full max-w-lg">


            <form method="POST" action="{{ route('register') }}">
                @csrf

                @forminput(['label' => 'name'])
                <input id="name" placeholder="{{ __('Name') }}" type="text"
                       class="orgusto-input @error('name') is-invalid @enderror"
                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @endforminput
                @error('name')
                <div class="flex text-red-600 text-italic text-sm mx-2">
                    {{ $message  }}
                </div>
                @enderror

                @forminput(['label' => 'email'])
                <input id="email" placeholder="{{ __('E-Mail Address') }}" type="email"
                       class="orgusto-input @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required autocomplete="email">
                @endforminput
                @error('email')
                <div class="flex text-red-600 text-italic text-sm mx-2">
                    {{ $message  }}
                </div>
                @enderror

                @forminput(['label' => 'password'])
                <input id="password" placeholder="{{ __('Password') }}" type="password"
                       class="orgusto-input @error('password') is-invalid @enderror"
                       name="password" required autocomplete="new-password">
                @endforminput
                @error('password')
                <div class="flex text-red-600 text-italic text-sm mx-2">
                    {{ $message  }}
                </div>
                @enderror

                @forminput(['label' => 'confirm password'])
                <input id="password-confirm" placeholder="{{ __('Confirm Password') }}" type="password"
                       class="orgusto-input"
                       name="password_confirmation" required autocomplete="new-password">
                @endforminput

                <div class="w-full flex justify-between items-center mt-2 p-2">

                    <button type="submit"
                            class="orgusto-button text-blue-600 hover:bg-blue-600 hover:text-white transition-colors duration-150 ease-in-out">
                        <i class="fas fa-user-check mr-2"></i> {{ __('Register') }}
                    </button>

                    <a class="text-sm text-gray-600 hover:text-blue-400" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>
                </div>
            </form>

        </div>
    </div>

    @endinfocard
@endsection
