@extends('layouts.app')

@section('content')
<div class="flex flex-col justify-around">

    @foreach ($reservations as $reservation)

    <reservation-list-item :reservation="{{ $reservation }}"></reservation-list-item>

    @endforeach

    <div class="flex flex-col justify-around">

        {{ $reservations->links() }}

    </div>
</div>
@endsection