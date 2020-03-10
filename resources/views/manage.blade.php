@extends('layouts.app')

@section('content')

<div class="absolute mt-2 w-full flex flex-row">


    <div class="w-full pl-4">

        <div class="mx-8">

            <div class="flex flex-row py-4">
                <div class="w-1/6">
                    <orgastro-timepicker></orgastro-timepicker>
                </div>
                <div class="w-5/6 flex flex-row justify-between px-1 self-stretch">
                    <button class="text-gray-600 bg-gray-200 hover:bg-gray-300 w-1/12 h-full rounded-full focus:outline-none">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="text-gray-600 bg-gray-200 hover:bg-gray-300 w-1/12 h-full rounded-full focus:outline-none">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>


        </div>

        <orgastro-timeline ihour="16"></orgastro-timeline>

        @foreach($tables as $table)

        <orgastro-table :tnumber="{{ $table->table_number }}" :reservations="{{ $table->reservations }}"></orgastro-table>

        @endforeach
    </div>


</div>




@endsection