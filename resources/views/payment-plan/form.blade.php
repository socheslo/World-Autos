@extends('layouts.app')

@section('title', 'Payment Plan Result')

@section('content')
<div class="container" style="max-width: 800px;">
    <h2 class="text-center">Your Payment Plan</h2>

    <!-- Виведення результатів -->
    @isset($priceInDollars)
    <div class="row">
        <!-- Виведення ціни в доларах -->
        <h3>Price: ${{ $priceInDollars }}</h3>
        
        <!-- Виведення щомісячного платежу -->
        <p><strong>Monthly Payment:</strong> ${{ number_format($monthlyPayment, 2) }}</p>

        <!-- Виведення загальної суми платежів -->
        <p><strong>Total Payment:</strong> ${{ number_format($totalPayment, 2) }}</p>

        <!-- Виведення загальних відсотків -->
        <p><strong>Total Interest:</strong> ${{ number_format($totalInterest, 2) }}</p>
    </div>
    @endisset

    <hr>

    <!-- Форма для введення нових даних -->
    <form method="POST" action="{{ route('payment.plan') }}">
        @csrf
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

        <div class="mb-3">
            <label for="repayment_duration" class="form-label">Repayment Duration</label>
            <select id="repayment_duration" name="repayment-duration" class="form-select">
                <option value="24">24 months</option>
                <option value="36">36 months</option>
                <option value="48">48 months</option>
                <option value="60">60 months</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="interest_rate" class="form-label">Interest Rate</label>
            <select id="interest_rate" name="interest-rate" class="form-select">
                <option value="2.99">Excellent credit (2.99% APR)</option>
                <option value="7.99">Average credit (7.99% APR)</option>
                <option value="13.99">In a financial crunch (13.99% APR)</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Calculate Payment Plan</button>
    </form>
</div>
@endsection
