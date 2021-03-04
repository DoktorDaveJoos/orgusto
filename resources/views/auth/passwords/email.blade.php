@extends('layouts.app')

@section('content')

    @infocard(['title' => __('auth.reset_password')])

    <div class="p-4 flex justify-center">

        <div class="w-full max-w-lg">

            <div class="text-gray-600 p-2 font-normal">
                @if (session('status'))
                    <div class="abg-green-600 text-gray-700 font-semibold" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="flex flex-col">

                        @forminput(['label' => 'email'])
                        <input id="email" placeholder="{{ __('auth.email') }}" type="email"
                               class="orgusto-input @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @endforminput
                        @error('email')
                        <div class="flex text-red-600 text-italic text-sm mx-2">
                            {{ $message  }}
                        </div>
                        @enderror

                    </div>

                    <div class="w-full flex justify-between items-center mt-2 p-2">

                        <button type="submit"
                                class="orgusto-button text-blue-600 hover:bg-blue-600 hover:text-white transition-colors duration-150 ease-in-out">
                            <i class="fas fa-share mr-2"></i>{{ __('auth.send_password_link') }}
                        </button>

                    </div>
                </form>

            </div>
        </div>

    </div>

    @endinfocard
@endsection
