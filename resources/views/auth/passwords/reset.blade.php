@extends('layouts.app')

@section('content')
<div class="container">
    <div class="flex justify-center">
        <div class="w-8/12">
            <div class="shadow-lg rounded-lg">
                <div class="bg-gray-200 w-full rounded-t-lg p-4 px-8 text-gray-700 text-xl">{{ __('Reset Password') }}</div>

                <div class="text-gray-600 p-2 font-normal">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="flex flex-col">
                            <div class="flex justify-center m-2">
                                <input id="email" placeholder="{{ __('E-Mail Address') }}" type="email" class="bg-gray-200 p-2 px-4 rounded-full w-8/12 focus:outline-none @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                            </div>
                            @error('email')
                            <div class="flex justify-center m-2">
                                <span class="bg-red-400 text-white w-8/12 rounded-lg p-2 mt-2 mb-2" role="alert">
                                    {{ $message }}
                                </span>
                            </div>
                            @enderror
                        </div>

                        <div class="flex flex-col">
                            <div class="flex justify-center m-2">
                                <input id="password" placeholder="{{ __('Password') }}" type="password" class="bg-gray-200 p-2 px-4 rounded-full w-8/12 focus:outline-none @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            </div>
                            @error('password')
                            <div class="flex justify-center m-2">
                                <span class="bg-red-400 text-white w-8/12 rounded-lg p-2 mt-2 mb-2" role="alert">
                                    {{ $message }}
                                </span>
                            </div>
                            @enderror
                        </div>

                        <div class="flex justify-center m-2">
                            <input id="password-confirm" placeholder="{{ __('Confirm Password') }}" type="password" class="bg-gray-200 p-2 px-4 rounded-full w-8/12 focus:outline-none" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="flex justify-center m-2">
                            <div class="w-8/12 p-2"></div>
                            <button type="submit" class="bg-blue-400 hover:bg-blue-500 rounded-full px-4 py-1 text-white mr-4">
                                {{ __('Reset Password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection