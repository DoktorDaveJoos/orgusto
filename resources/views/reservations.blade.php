@extends('layouts.vue')

@section('content')
<div class="flex flex-col justify-around">



    <div class="flex flex-row border-b-4 justify-end p-2 text-white mb-2 mt-2 w-8/12 self-center max-w-5xl">

        <input type="text" placeholder="Search" class="leading-tight rounded-full my-2 bg-gray-300 text-gray-800 px-4 focus:outline-none">

        <button class="orgusto-button bg-blue-200">
            Reservation
        </button>

    </div>

    <div class="mb-2 mt-2 rounded-lg w-8/12 self-center hover:shadow-lg max-w-5xl">
        <reservation-empty-item :tables="{{ $tables }}">
        </reservation-empty-item>
    </div>

    @foreach ($reservations as $reservation)

    <reservation-list-item :reservation="{{ $reservation }}"></reservation-list-item>

    @endforeach

    <div class="flex flex-col justify-around">

        {{ $reservations->links() }}

    </div>
</div>
@endsection
