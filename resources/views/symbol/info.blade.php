@extends('layouts.main')

@section('content')
    @livewire('symbol-table', ['symbol' => $symbol])
@endsection
