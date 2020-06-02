@extends('layouts.app')

@section('content')
<div class="container">
  <div class="flex justify-center">
    <div class="w-8/12">
      <div class="rounded-lg">
        <div class="bg-gray-200 w-full rounded-t-lg p-4 px-8 text-gray-700 text-xl">{{ __('Fullfill invitation') }}</div>

        <div class="text-gray-600 p-4 font-normal bg-white">
          <form method="POST" action="{{ route('invitation.update', ['user' => $user]) }}">
            @csrf

            @forminput(['label' => 'name'])
            <input id="name" placeholder="{{ __('Name') }}" type="text" class="orgusto-input" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>
            @error('name') <span class="text-sm text-red-600 font-light leading-tight">{{ $message }}</span> @enderror
            @endforminput

            @forminput(['label' => 'email'])
            <span class="leading-tight text-sm text-gray-600" name="email"><i class="fas fa-envelope mr-2"></i>{{ $user->email }}</span>
            @error('email') <span class="text-sm text-red-600 font-light leading-tight">{{ $message }}</span> @enderror
            @endforminput

            @forminput(['label' => 'password'])
            <input id="password" placeholder="{{ __('Password') }}" type="password" class="orgusto-input" name="password" required autocomplete="new-password">
            @error('password') <span class="text-sm text-red-600 font-light leading-tight">{{ $message }}</span> @enderror
            @endforminput

            @forminput(['label' => 'password confirmation'])
            <input id="password-confirm" placeholder="{{ __('Confirm Password') }}" type="password" class="orgusto-input" name="password_confirmation" required autocomplete="new-password">
            @error('password-confirm') <span class="text-sm text-red-600 font-light leading-tight">{{ $message }}</span> @enderror
            @endforminput

            <div class="w-8/12 p-2">
              <button type="submit" class="bg-blue-400 hover:bg-blue-500 rounded-full px-4 py-1 text-white mr-4">
                {{ __('Fullfill invitation') }}
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
