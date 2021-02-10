@extends('layouts.vue')

@section('content')

    <reservations-list></reservations-list>

{{--    <div class="w-full flex justify-center mt-4">--}}
{{--        <search-reservation search-endpoint="{{ route('reservations.search') }}"--}}
{{--                            reservation-endpoint="{{ route('reservations.show') }}"></search-reservation>--}}
{{--    </div>--}}

    @if($empty_search)
        <div class="orgusto-headline flex justify-center p-4 text-3xl text-gray-700">
            No reservations for this search criteria.
        </div>
        <div class="flex justify-center">
            {!! file_get_contents('img/empty_space.svg') !!}
        </div>
    @endif

@endsection

