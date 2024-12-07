@extends('layouts.app')

@section('title', 'Calculate Your Payment Plan')

@section('content')
<div class="container" style="max-width: 800px;">
    <h2 class="text-center">Calculate Your Payment Plan</h2>
    <form method="POST" action="{{ route('payment.plan') }}">
        @csrf

        <!-- Vehicle Details -->
        <div class="mb-3">
            <label for="make" class="form-label">Make</label>
            <input type="text" id="make" name="make" class="form-control" value="{{ old('make') }}" required>
        </div>
        <div class="mb-3">
            <label for="model" class="form-label">Model</label>
            <input type="text" id="model" name="model" class="form-control" value="{{ old('model') }}" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <div class="input-group">
                <span class="input-group-text">$</span>
                <input type="number" id="price" name="price" class="form-control" value="{{ old('price') }}" required>
            </div>
        </div>

        <!-- Repayment Duration -->
        <div class="mb-3">
            <label for="repayment_duration" class="form-label">Repayment Duration</label>
            <select id="repayment_duration" name="repayment-duration" class="form-select">
                <option value="24">24 months</option>
                <option value="36">36 months</option>
                <option value="48">48 months</option>
                <option value="60">60 months</option>
            </select>
        </div>

        <!-- Interest Rate -->
        <div class="mb-3">
            <label for="interest_rate" class="form-label">Interest Rate</label>
            <select id="interest_rate" name="interest-rate" class="form-select">
                <option value="2.99">Excellent credit (2.99% APR)</option>
                <option value="7.99">Average credit (7.99% APR)</option>
                <option value="13.99">In a financial crunch (13.99% APR)</option>
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary w-100">Calculate Payment Plan</button>
    </form>

    <hr>

    <!-- Додано відображення транспортних засобів -->
    <div class="row">
        @foreach($vehicles as $vehicle)
        <div class="col-md-12 mb-4">
            <div class="row align-items-center">
                <div class="col-md-3">
                    @if(file_exists(public_path('storage/' . $vehicle->image)))
                        <img src="{{ asset('storage/' . $vehicle->image) }}" class="img-fluid rounded" alt="{{ $vehicle->make }}"/>
                    @else
                        <p class="text-danger">Image not found</p>
                    @endif
                </div>
                <div class="col-md-9">
                    <h2 class="text-primary">{{ $vehicle->make }} <span class="text-info">{{ $vehicle->model }}</span></h2>
                    <p>
                        <strong>Year:</strong> {{ $vehicle->year }}<br>
                        <strong>Mileage:</strong> {{ number_format($vehicle->mileage) }}<br>
                        <strong>Price:</strong> ${{ number_format($vehicle->price, 2) }}
                    </p>
                </div>
            </div>
            <hr>
        </div>
        @endforeach
    </div>
</div>
@endsection