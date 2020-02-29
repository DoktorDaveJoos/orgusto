@extends('layouts.app')

@section('content')

<div class="absolute mt-2 w-full flex flex-row">


    <div class="w-full pl-4">

        <orgastro-timeline ihour="16"></orgastro-timeline>

        @foreach($tables as $table)
        
        <orgastro-table :tnumber="{{ $table->table_number }}" :reservations="{{ $table->reservations }}"></orgastro-table>

        @endforeach
    </div>


</div>

<!-- 
<manage-test></manage-test> -->



@endsection