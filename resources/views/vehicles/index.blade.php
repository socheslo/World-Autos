@extends('layouts.app')

@section('title', 'Vehicle List')

@section('content')
<div class="container">
    <h1 class="text-center text-primary mb-4">World Autos</h1>
    <p class="text-center text-info">Where everyone can afford to buy a vehicle!</p>

    <!-- Кнопка для додавання транспортного засобу -->
    <div class="mb-3 text-end">
        <a href="{{ route('vehicle.add') }}" class="btn btn-success">Add Your Vehicle</a>
    </div>

    <!-- Відображення автомобілів -->
    <div class="row">
        @foreach($vehicles as $vehicle)
        <div class="col-md-12 mb-4">
            <div class="row align-items-center">
                <div class="col-md-3">
                    @if(file_exists(public_path('images/' . $vehicle->image)))
                        <img src="{{ asset('images/' . $vehicle->image) }}" class="img-fluid rounded" alt="{{ $vehicle->make }}">
                    @elseif(Storage::disk('public')->exists($vehicle->image))
                        <img src="{{ asset('storage/' . $vehicle->image) }}" alt="{{ $vehicle->make }}" class="img-fluid rounded">
                    @else
                        <p class="text-danger">Image not found: {{ $vehicle->image }}</p>
                    @endif
                </div>
                <div class="col-md-9">
                    <h2 class="text-primary">{{ $vehicle->make }} <span class="text-info">{{ $vehicle->model }}</span></h2>
                    
                    <div class="vehicle-details">
                        <!-- Рік і пробіг на одному рядку -->
                        <div class="d-flex">
                            <span class="vehicle-year">Year: {{ $vehicle->year }}</span>
                            <span class="vehicle-mileage ml-3">Mileage: {{ number_format($vehicle->mileage) }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-2">
                            <span class="vehicle-price">${{ number_format($vehicle->price, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span class="vehicle-options" style="color: purple;">Options: (No additional options)</span>
                        </div>
                    </div>


                    <form action="{{ route('payment.plan') }}" method="post" class="mt-3">
                        @csrf
                        <input type="hidden" name="make" value="{{ $vehicle->make }}">
                        <input type="hidden" name="model" value="{{ $vehicle->model }}">
                        <input type="hidden" name="price" value="{{ $vehicle->price }}">
                        <input type="hidden" name="image" value="{{ $vehicle->image }}">
                        <p>
                            <label>Choose your repayment duration:</label>
                            <select class="form-select d-inline-block w-auto" name="repayment-duration">
                                <option value="24">24</option>
                                <option value="36">36</option>
                                <option value="48">48</option>
                                <option value="60">60</option>
                            </select> months
                        </p>
                        <p>
                            <label>Choose your credit health:</label>
                            <select class="form-select d-inline-block w-auto" name="interest-rate">
                                <option value="2.99">Excellent credit 2.99% APR</option>
                                <option value="7.99">Average credit 7.99% APR</option>
                                <option value="13.99">In a financial crunch 13.99% APR</option>
                            </select>
                        </p>
                        <button type="submit" class="btn btn-primary mt-3">See your personalised payment plan &gt;&gt;&gt;</button>
                    </form>
                </div>
            </div>
            <hr>
        </div>
        @endforeach
    </div>
</div>
@endsection
