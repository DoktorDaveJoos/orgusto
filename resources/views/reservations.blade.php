@extends('layouts.vue')

@section('content')

    <div class="w-full flex justify-center mt-4">
        <search-reservation search-endpoint="{{ route('reservations.search') }}"
                            reservation-endpoint="{{ route('reservations.show') }}"></search-reservation>
    </div>

    @if($empty_search)
        <div class="orgusto-headline flex justify-center p-4 text-3xl text-gray-700">
            No reservations for this search criteria.
        </div>
        <div class="flex justify-center">
            {!! file_get_contents('img/empty_space.svg') !!}
        </div>
    @endif

    @infocard(['title' => $empty_search ? '... upcoming reservations' : 'Reservations'])
    @table
    @slot('table_head')
    @endslot

    @slot('table_body')
        @foreach($reservations as $reservation)
            <tr class="hover:bg-{{ $reservation->color }}-100 border-t border-gray-200">
                <td class="px-6 flex text-left border-l-8 border-{{ $reservation->color }}-400">
                    <div class="flex flex-row w-1/4 items-center">
                        <div class="leading-5 text-gray-800 mr-8">{{ $reservation->name }}</div>
                    </div>
                    <div class="flex-1 flex flex-wrap space-y-2 space-x-2 mr-4 mb-2">

                        <!-- Root elem for space-y-1 -->
                        <div></div>

                        <div
                            class="leading-tight shadow-lg text-xs text-white px-2 py-1 rounded-full bg-{{ $reservation->color }}-600">
                            <i class="text-white pr-1 fas fa-calendar-day"></i>
                            {{ $reservation->getHumanReadableDate() }}
                        </div>

                        <div
                            class="leading-tight shadow-lg text-xs text-white px-2 py-1 rounded-full bg-{{ $reservation->color }}-600">
                            <i class="text-white pr-1 fas fa-clock"></i>
                            {{ $reservation->getHumanReadableTime() }}
                        </div>

                        <div
                            class="leading-tight shadow-lg text-xs text-white px-2 py-1 rounded-full bg-{{ $reservation->color }}-600">
                            <i class="text-white pr-1 fas fa-user-friends"></i>{{ $reservation->persons }} Persons
                        </div>

                        @foreach($reservation->tables as $table)
                            <div
                                class="leading-tight shadow-lg text-xs text-white px-2 py-1 rounded-full bg-{{ $reservation->color }}-600">
                                <i class="text-white pr-1 fas fa-chair"></i>{{ $table->table_number }}
                            </div>
                        @endforeach

                        @if($reservation->email)
                            <div
                                class="leading-tight shadow-lg text-xs text-white px-2 py-1 rounded-full bg-{{ $reservation->color }}-600">
                                <i class="text-white pr-1 fas fa-envelope"></i>{{ $reservation->email }}
                            </div>
                        @endif

                        @if($reservation->phone_number)
                            <div
                                class="leading-tight shadow-lg text-xs text-white px-2 py-1 rounded-full bg-{{ $reservation->color }}-600">
                                <i class="text-white pr-1 fas fa-phone-alt"></i>{{ $reservation->phone_number }}
                            </div>
                        @endif
                    </div>

                    <edit-reservation :reservation="{{ $reservation }}"
                                      tables-endpoint="{{ route('tables.index') }}"
                                      reservations-endpoint="{{ route('reservation.update', $reservation->id) }}">
                    </edit-reservation>
                </td>

            </tr>
        @endforeach
    @endslot
    @endtable

    <div class="p-2 px-2 text-gray-600 text-xs font-light border-t border-gray-200 bg-gray-200">
        {{ $reservations->withQueryString()->links() }}
    </div>

    @endinfocard

@endsection
