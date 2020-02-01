@extends('layouts.app')

@section('content')
<div class="container">
    <div class="flex justify-center">
        <div class="w-8/12">
            <div class="shadow-lg rounded-lg">
                <div class="bg-gray-200 w-full rounded-t-lg p-4 px-8 text-gray-700 text-xl">{{ __('Verify Your Email Address') }}</div>

                <div class="text-gray-600 p-2 font-normal">
                    @if (session('resent'))
                    <div class="bg-green-400 textwhite w-8/12 rounded-lg p-2 mt-2 mb-2" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="bg-blue-400 hover:bg-blue-500 rounded-full px-4 py-1 text-white mr-4">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection