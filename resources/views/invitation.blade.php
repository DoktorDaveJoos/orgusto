@extends('layouts.app')

@section('content')

    @infocard(['title' => __('Fullfill invitation')])

    <div class="p-4 flex justify-center">

        <div class="w-full max-w-lg">
            <form method="POST" action="{{ route('invitation.update', ['user' => $user]) }}">
                @csrf

                @forminput(['label' => 'name'])
                <input id="name" placeholder="{{ __('Name') }}" type="text" class="orgusto-input" name="name"
                       required autocomplete="name" autofocus>
                @error('name') <span
                    class="text-sm text-red-600 font-light leading-tight">{{ $message }}</span> @enderror
                @endforminput

                @forminput(['label' => 'email'])
                <span class="leading-tight text-sm text-gray-600" name="email"><i class="fas fa-envelope mr-2"></i>{{ $user->email }}</span>
                @error('email') <span
                    class="text-sm text-red-600 font-light leading-tight">{{ $message }}</span> @enderror
                @endforminput

                @forminput(['label' => 'password'])
                <input id="password" placeholder="{{ __('Password') }}" type="password" class="orgusto-input"
                       name="password" required autocomplete="new-password">
                @error('password') <span
                    class="text-sm text-red-600 font-light leading-tight">{{ $message }}</span> @enderror
                @endforminput

                @forminput(['label' => 'password confirmation'])
                <input id="password-confirm" placeholder="{{ __('Confirm Password') }}" type="password"
                       class="orgusto-input" name="password_confirmation" required autocomplete="new-password">
                @error('password-confirm') <span
                    class="text-sm text-red-600 font-light leading-tight">{{ $message }}</span> @enderror
                @endforminput

                <div class="w-full flex justify-between items-center mt-2 p-2">
                    <button type="submit" class="orgusto-button text-blue-600 hover:bg-blue-600 hover:text-white transition-colors duration-150 ease-in-out">
                        {{ __('Fullfill invitation') }}
                    </button>
                </div>

            </form>
        </div>



    </div>

    @endinfocard
@endsection
