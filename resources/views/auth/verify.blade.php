@extends('layouts.app')

@section('content')

    @infocard(['title' => __('auth.verify')])

    <div
        class="bg-gray-200 w-full rounded-t-lg p-4 px-8 text-gray-700 text-xl">{{ __('auth.verify_email') }}</div>

    <div class="text-gray-600 p-2 font-normal">
        @if (session('resent'))
            <div class="bg-green-400 textwhite w-8/12 rounded-lg p-2 mt-2 mb-2" role="alert">
                {{ __('auth.verification_link_sent') }}
            </div>
        @endif

        {{ __('auth.check_verification_link') }}
        {{ __('auth.email_not_received') }},
        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit"
                    class="bg-blue-400 hover:bg-blue-500 rounded-full px-4 py-1 text-white mr-4">{{ __('auth.request_another') }}</button>
            .
        </form>
    </div>

    @endinfocard



    </div>
@endsection
