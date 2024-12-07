@extends('layouts.app')

@section('title', 'Your Personalised Payment Plan')

@section('content')
<div class="container text-center" style="background-color: #f9c74f; padding: 20px; border-radius: 10px;">
    <h1 style="color: #003366;">Your Personalised Payment Plan</h1>
    
    <!-- Зображення автомобіля -->
    @if(file_exists(public_path('images/' . $loan->image)))
        <!-- Для статичних зображень -->
        <img class="img-fluid" src="{{ asset('images/' . $loan->image) }}" alt="vehicle-image" style="max-width: 300px; margin: 20px auto;">
    @elseif(Storage::disk('public')->exists($loan->image))
        <!-- Для завантажених зображень -->
        <img class="img-fluid" src="{{ asset('storage/' . $loan->image) }}" alt="vehicle-image" style="max-width: 300px; margin: 20px auto;">
    @else
        <!-- Якщо зображення не знайдено -->
        <p class="text-danger">Image not found: {{ $loan->image }}</p>
    @endif

    <!-- Відображення марки та моделі -->
    <p style="font-size: 24px; color: #003366; font-weight: bold;">{{ $loan->make }}</p>
    <p style="font-size: 20px; color: #003366;">{{ $loan->model }}</p>

    <hr style="border: 1px solid #003366;">

    <!-- Ціна автомобіля -->
    <p style="font-size: 28px; color: #e63946; font-weight: bold;">${{ number_format($loan->price, 2) }}</p>

    <!-- Тривалість виплат -->
    <p style="font-size: 16px;">
        <span style="font-weight: bold;">Repayment duration:</span> {{ $loan->repayment_duration }} months
    </p>

    <!-- Відсоткова ставка -->
    <p style="font-size: 16px;">
        <span style="font-weight: bold;">Interest rate:</span> {{ $loan->interest_rate }}% APR
    </p>

    <hr style="border: 1px solid #003366;">

    <!-- Загальна сума виплат -->
    <p style="font-size: 16px;">
        <span style="font-weight: bold;">Total payment:</span> ${{ number_format($loan->total_payment, 2) }}
    </p>

    <!-- Загальна сума відсотків -->
    <p style="font-size: 16px;">
        <span style="font-weight: bold;">Total interest:</span> ${{ number_format($loan->total_interest, 2) }}
    </p>

    <hr style="border: 2px solid green;">

    <!-- Щомісячний платіж -->
    <p style="font-size: 24px; color: green; font-weight: bold;">
        Monthly payment: ${{ number_format($loan->monthly_payment, 2) }}
    </p>
</div>
@endsection
