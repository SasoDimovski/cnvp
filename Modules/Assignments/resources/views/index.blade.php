@extends('assignments::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('assignments.name') !!}</p>
@endsection
