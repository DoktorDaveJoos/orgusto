@extends('layouts.app')

@section('content')

<div class="absolute mt-2 w-full flex flex-row">


    <div class="w-full pl-4">

        <div class="mx-8">

        <div class="w-1/6">
            <orgastro-timepicker></orgastro-timepicker>
        
        </div>

        
        </div>

        <orgastro-timeline ihour="16"></orgastro-timeline>

        @foreach($tables as $table)
        
        <orgastro-table :tnumber="{{ $table->table_number }}" :reservations="{{ $table->reservations }}"></orgastro-table>

        @endforeach
    </div>


</div>

<!-- 
<manage-test></manage-test> -->



@endsection