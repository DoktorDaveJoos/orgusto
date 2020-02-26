@extends('layouts.app')

@section('content')

<div class="absolute mt-2 w-full flex flex-row">


    <div class="w-full pl-4">

        <orgastro-timeline ihour="16"></orgastro-timeline>

        @foreach(range(1, Auth::user()->restaurants()->first()->table_count) as $tableNumber)

        <orgastro-table tnumber="{{ $tableNumber }}" :reservations='@json(Auth::user()->reservations->where("tables", $tableNumber))'></orgastro-table>

        @endforeach
    </div>

</div>

<!-- 
<manage-test></manage-test> -->



@endsection