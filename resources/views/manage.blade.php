@extends('layouts.vue')

@section('content')

    @if(sizeof($tables) === 0)

        <div class="orgusto-headline flex justify-center p-4 text-3xl text-gray-700">
            You don't have any tables so far.
        </div>
        <div class="flex justify-center">
            {!! file_get_contents('img/empty_space.svg') !!}
        </div>

    @else

        <orgusto-scope-manager date="{{ $date ?? date('Y-m-d') }}"
                               scope="{{ $scopedHour ?? '17' }}"></orgusto-scope-manager>

        <div class="w-full pl-4">
            <div class="mx-8">
                <div class="flex flex-row py-4">
                    <div class="w-1/6">
                        <orgastro-timepicker date="{{ $date }}"></orgastro-timepicker>
                    </div>
                    <div class="w-5/6 flex flex-row justify-between px-1 self-stretch">
                        <orgusto-scope-button direction="left"></orgusto-scope-button>
                        <orgusto-scope-button direction="right"></orgusto-scope-button>
                    </div>
                </div>
            </div>

            <orgusto-timeline ihour="{{ $scopedHour ?? '17' }}"></orgusto-timeline>

            <orgusto-tables timeline-start="{{ $date.' '.$scopedHour.':00:00' }}"
                            :tables="{{ $tables }}"
                            :employees="{{ $employees }}"
                            tables-endpoint="{{ route('tables.index') }}"
                            reservations-endpoint="{{ route('reservation.update', '') }}"
            ></orgusto-tables>

        </div>
    @endif

@endsection
