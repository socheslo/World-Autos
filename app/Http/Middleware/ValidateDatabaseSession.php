<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ValidateDatabaseSession
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $sessionId = session()->getId(); // Отримуємо ID поточної сесії

            // Перевіряємо, чи існує сесія в таблиці
            $sessionExists = DB::table('sessions')->where('id', $sessionId)->exists();

            if (!$sessionExists) {
                // Якщо сесія видалена, виходимо з системи
                Log::warning('Сесія не знайдена або видалена для ID: ' . $sessionId);

                Auth::logout(); // Вихід користувача
                session()->invalidate(); // Очищення локальної сесії
                session()->regenerateToken(); // Генерація нового CSRF-токена

                // Перенаправлення на сторінку логіну чи реєстрації
                return redirect()->route('auth.selection')->with('error', 'Сесія завершена. Будь ласка, увійдіть або зареєструйтеся.');
            }
        }

        return $next($request);
    }
}
