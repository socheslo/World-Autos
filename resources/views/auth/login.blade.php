@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container">
    <h2 class="text-center">Login</h2>
    <form method="POST" action="{{ route('login') }}" class="mt-4">
        @csrf
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}" required>
            @error('username') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" required>
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
    <p class="mt-3 text-center">
        Don't have an account? <a href="{{ route('register') }}">Register</a>
    </p>
</div>
@endsection
