@extends('languages::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('languages.name') !!}</p>
@endsection
