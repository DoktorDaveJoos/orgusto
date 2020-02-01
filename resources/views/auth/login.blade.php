@extends('layouts.app')

@section('content')
<div class="container">
    <div class="flex justify-center">
        <div class="w-8/12">
            <div class="shadow-lg rounded-lg">
                <div class="bg-gray-200 w-full rounded-t-lg p-4 px-8 text-gray-700 text-xl">{{ __('Login') }}</div>

                <div class="text-gray-600 p-2 font-normal">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="w-full flex justify-center m-2">

                            <input id="email" placeholder="{{ __('Email Adresse') }}" type="email" class="bg-gray-200 p-2 px-4 rounded-full w-8/12 @error('email') is-invalid @enderror focus:outline-none" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                            <span class="bg-red-600 text-gray-700 font-semibold" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>

                        <div class="w-full flex justify-center m-2">


                            <input id="password" placeholder="{{ __('Password') }}" type="password" class="bg-gray-200 p-2 px-4 rounded-full w-8/12 @error('password') is-invalid @enderror focus:outline-none" name="password" required autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>

                        <div class="w-full flex justify-center m-2">

                            <div class="w-8/12 p-2 px-4">

                                <input class="self-center mr-2" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="self-center" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>



                        </div>

                        <div class="w-full flex justify-center m-2">

                            <div class="w-8/12 p-2">
                                <button type="submit" class="bg-blue-400 hover:bg-blue-500 rounded-full px-4 py-1 text-white mr-4">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                <a class="font text-sm hover:text-blue-400" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                                @endif

                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection