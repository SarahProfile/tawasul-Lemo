@extends('layouts.app')

@section('title', 'Elevated Travel Experience')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    @include('content.home-content')
@endsection