@extends('layouts.app')

@section('content')
<div class="container">
    <h1>World Autos</h1>
    <div class="row">
        @foreach($vehicles as $vehicle)
        <div class="col-md-4 mb-3">
            <div class="card">
                <img src="{{ asset('images/' . $vehicle->image) }}" class="card-img-top" alt="{{ $vehicle->make }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $vehicle->make }} {{ $vehicle->model }}</h5>
                    <p class="card-text">
                        <strong>Price:</strong> ${{ number_format($vehicle->price, 2) }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
