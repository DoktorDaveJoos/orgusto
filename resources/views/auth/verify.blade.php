@extends('layouts.app')

@section('content')


    <div class="max-w-7xl mx-auto py-12 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">

            <div class="bg-gray-50 sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        {{ __('auth.verify') }}
                    </h3>
                    <div class="mt-2 max-w-xl text-sm text-gray-500">
                        <p class="py-2">
                            {{ __('auth.verify_email') }}
                        </p>

                        @if (session('resent'))
                            <p class="text-red-600 py-2">
                                {{ __('auth.verification_link_sent') }}
                            </p>
                        @endif

                        <p class="py-2">
                            {{ __('auth.check_verification_link') }}
                        </p>
                        <p class="py-2">
                            {{ __('auth.email_not_received') }},
                        </p>
                    </div>
                    <div class="mt-5">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('auth.request_another') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
