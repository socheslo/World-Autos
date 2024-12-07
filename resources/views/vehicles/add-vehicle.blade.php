@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center" style="color: #003366;">Add a New Vehicle</h2>
    <form method="POST" action="{{ route('vehicle.store') }}" enctype="multipart/form-data" style="margin-top: 20px;">
        @csrf

        <!-- Vehicle Make -->
        <div class="mb-3">
            <label for="make" class="form-label" style="font-weight: bold; color: #003366;">Vehicle Make</label>
            <input type="text" id="make" name="make" class="form-control" required>
            @error('make') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- Vehicle Model -->
        <div class="mb-3">
            <label for="model" class="form-label" style="font-weight: bold; color: #003366;">Vehicle Model</label>
            <input type="text" id="model" name="model" class="form-control" required>
            @error('model') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- Year -->
        <div class="mb-3">
            <label for="year" class="form-label" style="font-weight: bold; color: #003366;">Year</label>
            <input type="number" id="year" name="year" class="form-control" required>
            @error('year') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- Mileage -->
        <div class="mb-3">
            <label for="mileage" class="form-label" style="font-weight: bold; color: #003366;">Mileage</label>
            <input type="number" id="mileage" name="mileage" class="form-control" required>
            @error('mileage') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- Price -->
        <div class="mb-3">
            <label for="price" class="form-label" style="font-weight: bold; color: #003366;">Price ($)</label>
            <input type="number" id="price" name="price" class="form-control" required>
            @error('price') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- Image -->
        <div class="mb-3">
            <label for="image" class="form-label" style="font-weight: bold; color: #003366;">Vehicle Image</label>
            <input type="file" id="image" name="image" class="form-control" required>
            @error('image') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100" style="background-color: #003366; border-color: #003366;">Add Vehicle</button>
    </form>
</div>
@endsection