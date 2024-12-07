@extends('layouts.app')

@section('title', 'Add Vehicle')

@section('content')
<div class="container" style="max-width: 600px;">
    <h2 class="text-center">Add a New Vehicle</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('vehicle.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="make" class="form-label">Make</label>
            <input type="text" id="make" name="make" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="model" class="form-label">Model</label>
            <input type="text" id="model" name="model" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="year" class="form-label">Year</label>
            <input type="number" id="year" name="year" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="mileage" class="form-label">Mileage</label>
            <input type="number" id="mileage" name="mileage" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" id="price" name="price" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Vehicle Image</label>
            <input type="file" id="image" name="image" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Add Vehicle</button>
    </form>
</div>
@endsection