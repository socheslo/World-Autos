<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\PaymentPlanController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Якщо хочете зберегти сторінку welcome як окрему
Route::get('/welcome', function () {
    return view('welcome');
});

// Головна сторінка для авторизованих користувачів
Route::get('/', [VehicleController::class, 'index'])->name('home')->middleware('auth');

// Маршрути авторизації
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Маршрути для транспортних засобів
Route::get('/add-vehicle', [VehicleController::class, 'showAddVehicleForm'])->name('vehicle.add')->middleware('auth');
Route::post('/add-vehicle', [VehicleController::class, 'storeVehicle'])->name('vehicle.store')->middleware('auth');
Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index')->middleware('auth');

// Маршрути для плану платежів
Route::post('/payment-plan', [PaymentPlanController::class, 'calculate'])->middleware('auth')->name('payment.plan');
Route::get('/payment-plan/{loanId}', [PaymentPlanController::class, 'showPaymentPlan'])->middleware('auth')->name('payment.plan.result');

// Фіксування паролів у базі даних
Route::get('/fix-passwords', function () {
    $users = User::all();

    foreach ($users as $user) {
        if (!Hash::needsRehash($user->password)) {
            $user->password = Hash::make($user->password); // Хешування пароля
            $user->save(); // Збереження змін у базі даних
            echo "Password fixed for user: {$user->username}<br>";
        } else {
            echo "Password already hashed for user: {$user->username}<br>";
        }
    }

    return 'All passwords checked and fixed if needed.';
});
