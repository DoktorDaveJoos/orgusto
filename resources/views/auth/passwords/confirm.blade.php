@extends('layouts.app')

@section('content')
<div class="container">
    <div class="flex justify-center">
        <div class="w-8/12">
            <div class="shadow-lg rounded-lg">
                <div class="bg-gray-200 w-full rounded-t-lg p-4 px-8 text-gray-700 text-xl">{{ __('Confirm Password') }}</div>

                <div class="text-gray-600 p-2 font-normal">
                    {{ __('Please confirm your password before continuing.') }}

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="flex flex-col">
                            <div class="flex justify-center m-2">
                                <input id="password" placeholder="{{ __('Password') }}" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
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
                            <div class="w-8/12 p-2">
                                <button type="submit" class="bg-blue-400 hover:bg-blue-500 rounded-full px-4 py-1 text-white mr-4">
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
            </div>
        </div>
    </div>
</div>
@endsection