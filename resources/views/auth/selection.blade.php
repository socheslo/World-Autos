@extends('layouts.app')

@section('title', 'Select Action')

@section('content')
<div class="container text-center mt-5">
    <h1>Welcome!</h1>
    <p class="lead">Please choose whether to log in or register to continue.</p>

    <!-- Повідомлення про завершення сесії -->
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="d-flex justify-content-center gap-3 mt-4">
        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
        <a href="{{ route('register') }}" class="btn btn-success">Register</a>
    </div>
</div>
@endsection
