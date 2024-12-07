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
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('home');
        }

        return back()->withErrors(['username' => 'Invalid credentials'])->withInput();
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        // Перевірка, чи користувач аутентифікований
        if (Auth::check()) {
            // Отримуємо ID користувача
            $userId = Auth::id();
    
            // Видаляємо всі записи користувача з бази даних
            $vehicles = Vehicle::where('user_id', $userId)->get();
    
            foreach ($vehicles as $vehicle) {
                // Видаляємо файл зображення, якщо він існує
                if (Storage::disk('public')->exists($vehicle->image)) {
                    Storage::disk('public')->delete($vehicle->image);
                }
    
                // Видаляємо запис з бази даних
                $vehicle->delete();
            }
    
            // Виконуємо стандартний logout
            Auth::logout();
    
            // Інвалідовуємо сесію
            $request->session()->invalidate();
            $request->session()->regenerateToken();
    
            // Перенаправляємо на сторінку входу
            return redirect()->route('login')->with('success', 'You have been logged out and your data has been removed.');
        }
    
        // Якщо користувач не аутентифікований
        return redirect()->route('login')->with('error', 'You are not logged in.');
    }

}
