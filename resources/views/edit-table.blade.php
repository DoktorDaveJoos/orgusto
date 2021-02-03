@extends('layouts.app')

@section('content')

    <livewire:edit-table :restaurant="$restaurant" :table="$table" />

@endsection
