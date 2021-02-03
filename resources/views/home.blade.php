@extends('layouts.app')

@section('content')

<div class="w-full h-full flex justify-center">
  <img class="hidden lg:block" src="{{ asset('img/start-page-response-frame.svg')}}" />
  <img class="lg:absolute p-4" src="{{ asset('img/start-page-welcome.svg')}}" />
</div>
<div class="flex justify-center">

  <a href="{{ route('register') }}" class="w-56 bg-indigo-500 shadow-lg text-white rounded-lg p-4 lg:mt-40 xl:mt-24 text-center">
    Jetzt kostenlos testen!
  </a>

</div>


@endsection
