<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Vehicle;

class AuthController extends Controller
{
    // Показує форму для входу
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Обробка спроби входу користувача
    public function login(Request $request)
    {
        // Валідує вхідні дані користувача
        $credentials = $request->validate([
            'username' => 'required|string', // Ім'я користувача має бути обов'язковим і рядком
            'password' => 'required|string', // Пароль має бути обов'язковим і рядком
        ]);

        // Спроба аутентифікації користувача
        if (Auth::attempt($credentials)) {
            // Якщо успішно, регенеруємо сесію для захисту від атак CSRF
            $request->session()->regenerate();

            // Перенаправляємо на головну сторінку
            return redirect()->route('home');
        }

        // Якщо невірні дані для входу, повертаємо помилку
        return back()->withErrors(['username' => 'Invalid credentials'])->withInput();
    }

    // Показує форму для реєстрації користувача
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Обробка реєстрації нового користувача
    public function register(Request $request)
    {
        // Валідує вхідні дані реєстрації
        $request->validate([
            'username' => 'required|string|unique:users', // Ім'я користувача має бути унікальним в таблиці users
            'email' => 'required|email|unique:users', // Email має бути унікальним і валідним
            'password' => 'required|string|confirmed|min:8', // Пароль має бути підтверджений і мінімум 8 символів
        ]);

        // Створює нового користувача в базі даних
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Пароль хешується перед збереженням
        ]);

        // Логін користувача після успішної реєстрації
        Auth::login($user);

        // Перенаправлення на головну сторінку
        return redirect()->route('home');
    }

    // Обробка виходу користувача
    public function logout(Request $request)
    {
        // Перевіряє, чи користувач аутентифікований
        if (Auth::check()) {
            // Отримуємо ID поточного користувача
            $userId = Auth::id();
    
            // Отримуємо всі транспортні засоби, що належать користувачу
            $vehicles = Vehicle::where('user_id', $userId)->get();
    
            // Видаляємо кожен транспортний засіб разом з його зображенням
            foreach ($vehicles as $vehicle) {
                // Якщо файл зображення існує на диску, видаляємо його
                if (Storage::disk('public')->exists($vehicle->image)) {
                    Storage::disk('public')->delete($vehicle->image);
                }
    
                // Видаляємо запис про транспортний засіб з бази даних
                $vehicle->delete();
            }
    
            // Логін користувача після виходу
            Auth::logout();
    
            // Інвалідовуємо сесію користувача
            $request->session()->invalidate();
            // Регенеруємо CSRF-токен для захисту від атак
            $request->session()->regenerateToken();
    
            // Перенаправляємо на сторінку входу з повідомленням про успішний вихід
            return redirect()->route('login')->with('success', 'You have been logged out and your data has been removed.');
        }
    
        // Якщо користувач не аутентифікований, перенаправляємо на сторінку входу
        return redirect()->route('login')->with('error', 'You are not logged in.');
    }
}

