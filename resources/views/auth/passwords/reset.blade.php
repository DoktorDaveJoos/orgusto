@extends('layouts.app')

@section('content')

    @infocard(['title' => __('Reset Password')])

    <div class="p-4 flex justify-center">

        <div class="w-full max-w-lg">

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                @forminput(['label' => 'email'])
                <input id="email" placeholder="{{ __('E-Mail Address') }}" type="email"
                       class="orgusto-input @error('email') is-invalid @enderror"
                       name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
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

                @forminput(['label' => 'Confirm password'])
                <input id="password-confirm" placeholder="{{ __('Confirm Password') }}" type="password"
                       class="orgusto-input" name="password_confirmation"
                       required autocomplete="new-password">
                @endforminput

                <div class="w-full flex justify-between items-center mt-2 p-2">
                    <button type="submit"
                            class="orgusto-button text-blue-600 hover:bg-blue-600 hover:text-white transition-colors duration-150 ease-in-out">
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </form>
        </div>

    </div>

    @endinfocard
@endsection
