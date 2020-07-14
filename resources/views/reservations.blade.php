@extends('layouts.vue')

@section('content')

<div class="w-full flex justify-center mt-4">
    <search-reservation search-endpoint="{{ route('reservations.search') }}" reservation-endpoint="{{ route('reservations.show') }}"></search-reservation>
</div>

@if($empty_search)

<div class="orgusto-headline flex justify-center p-4 text-3xl text-gray-700">
    No reservations for this search criteria.
</div>
<div class="flex justify-center">
    {!! file_get_contents('img/empty_space.svg') !!}
</div>
@endif

@infocard(['title' => $card_title])
@table
@slot('table_head')
@endslot

@slot('table_body')
@foreach($reservations as $reservation)
<tr class="hover:bg-{{ $reservation->color }}-100">
    <td class="px-6 py-4 flex text-left border-l-8 border-{{ $reservation->color }}-400">
        <div class="flex-1 flex flex-row">

            <div class="leading-5 text-gray-800 mr-8">{{ $reservation->name }}</div>

            <div class="leading-tight shadow-lg text-xs text-white mr-4 px-2 py-1 rounded-full bg-{{ $reservation->color }}-600">
                <i class="text-white pr-1 fas fa-calendar-day"></i>
                {{ $reservation->getHumanReadableDate() }}
            </div>

            <div class="leading-tight shadow-lg text-xs text-white mr-4 px-2 py-1 rounded-full bg-{{ $reservation->color }}-600">
                <i class="text-white pr-1 fas fa-clock"></i>
                {{ $reservation->getHumanReadableTime() }}
            </div>

            <div class="leading-tight shadow-lg text-xs text-white mr-4 px-2 py-1 rounded-full bg-{{ $reservation->color }}-600">
                <i class="text-white pr-1 fas fa-user-friends"></i>{{ $reservation->persons }} Persons
            </div>

            @if($reservation->email)
            <div class="leading-tight shadow-lg text-xs text-white mr-4 px-2 py-1 rounded-full bg-{{ $reservation->color }}-600">
                <i class="text-white pr-1 fas fa-envelope"></i>{{ $reservation->email }}
            </div>
            @endif

            @if($reservation->phone_number)
            <div class="leading-tight shadow-lg text-xs text-white mr-4 px-2 py-1 rounded-full bg-{{ $reservation->color }}-600">
                <i class="text-white pr-1 fas fa-phone-alt"></i>{{ $reservation->phone_number }}
            </div>
            @endif
        </div>
        <div class="flex">
            <button class="text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-full leading-tight text-xs px-2 py-1"><i class="far fa-edit mr-1"></i>Edit</button>
            <orgusto-modal-wrapper :is-open="true" :handle-close="() => {}">
                <reservation-item :employees="{{ $employees }}" tables-endpoint="{{ route('tables.index') }}" reservations-endpoint="{{ route('reservations.store') }}">
                </reservation-item>
            </orgusto-modal-wrapper>
            <button class="ml-4 text-red-600 hover:bg-red-600 hover:text-white rounded-full leading-tight text-xs px-2 py-1"><i class="far fa-trash-alt mr-1"></i>Delete</button>
        </div>
    </td>

</tr>
@endforeach
@endslot
@endtable

<div class="p-1 px-5 text-gray-600 text-xs font-light">
    {{ $reservations->links() }}
</div>

@endinfocard

@endsection
