@extends('layouts.app')

@section('content')

<div class="absolute mt-2 w-full flex flex-row">

    <orgusto-scope-manager date="{{ $date ?? date('Y-m-d') }}" scope="{{ $scopedHour ?? '17' }}"></orgusto-scope-manager>

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

        <orgastro-timeline ihour="{{ $scopedHour ?? '17' }}"></orgastro-timeline>

        @foreach($tables as $table)

        <orgastro-table timeline-start="{{ $date.' '.$scopedHour.':00:00' }}" :tnumber="{{ $table->table_number }}" :reservations="{{ $table->reservations }}"></orgastro-table>

        @endforeach
    </div>


</div>




@endsection