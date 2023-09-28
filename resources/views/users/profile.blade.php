@extends('layouts.app')

@section('content')
    @include('../includes/navbar')
    @include('../includes/messages')
    <div class="container">
        <h1>{{ $user->name }}</h1>
    </div>
@endsection
