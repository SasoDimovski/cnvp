@extends('public::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('public.name') !!}</p>
@endsection
