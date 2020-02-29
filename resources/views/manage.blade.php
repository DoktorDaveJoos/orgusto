@extends('layouts.app')

@section('content')

<div class="absolute mt-2 w-full flex flex-row">


    <div class="w-full pl-4">

        <orgastro-timeline ihour="16"></orgastro-timeline>

        @php
        $filterByTable = function ($arrayToFilter, $number) {
                if (in_array($number, $arrayToFilter['tables'])) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            };
        @endphp

        @foreach(range(1, $userData->restaurants[0]->table_count) as $tableNumber)

        <orgastro-table :tnumber="{{ $tableNumber }}" :reservations="{{ array_filter($userData->reservations->toArray(), $filterByTable, $tableNumber) }}"></orgastro-table>

        @endforeach
    </div>


</div>

<!-- 
<manage-test></manage-test> -->



@endsection