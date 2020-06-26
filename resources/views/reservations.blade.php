@extends('layouts.vue')

@section('content')

<div class="w-full flex justify-center mt-4">
    <search-reservation search-endpoint="{{ route('reservations.search') }}" reservation-endpoint="{{ route('reservations.show') }}"></search-reservation>
</div>

@if(sizeof($reservations) === 0)

<div class="orgusto-headline flex justify-center p-4 text-3xl text-gray-700">
    No reservations for this search criteria.
</div>
<div class="flex justify-center">
    {!! file_get_contents('img/empty_space.svg') !!}
</div>
@endif

@foreach ($reservations as $reservation)

@infocard(['optional_color' => $reservation->color])

@slot('title')
<span class="text-gray-800 text-base font-normal">
    {{ $reservation->name }}
</span>
<span class="border-r-2 border-gray-600 ml-1 mr-2">

</span>
<span class="text-gray-600 text-sm font-normal">
    {{ $reservation->getHumanReadableDate() }}
</span>
@endslot

@if($reservation->notice)
<div class="p-4 border-b border-gray-200 text-sm text-gray-600 leading-tight">
    {{ $reservation->notice }}
</div>
@endif

<div class="p-3">
    <span class="inline-block bg-gray-200 rounded-full shadow px-3 py-1 text-xs leading-tight text-gray-600 mr-2">
        <i class="fas fa-hourglass"></i>
        {{ $reservation->length }} h
    </span>
    <span class="inline-block bg-gray-200 rounded-full shadow px-3 py-1 text-xs leading-tight text-gray-600 mr-2">
        <i class="fas fa-user-friends"></i>
        {{ $reservation->person_count }} Persons
    </span>
    <span class="inline-block bg-gray-200 rounded-full shadow px-3 py-1 text-xs leading-tight text-gray-600 mr-2">{{ $reservation->user->name }}</span>

    @if ($reservation->email)
    <span class="inline-block bg-gray-200 rounded-full shadow px-3 py-1 text-xs leading-tight text-gray-600 mr-2">
        <i class="fas fa-envelope"></i>
        {{ $reservation->email }}
    </span>
    @endif
    @if ($reservation->phone_number)
    <span class="inline-block bg-gray-200 rounded-full shadow px-3 py-1 text-xs leading-tight text-gray-600 mr-2">
        <i class="fas fa-phone"></i>
        {{ $reservation->phone_number }}
    </span>
    @endif

</div>

@endinfocard

@endforeach

@endsection
