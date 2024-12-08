<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    // Вказуємо, яку таблицю використовує ця модель
    protected $table = 'loans';

    // Поля, які дозволено заповнювати (масова присвоєння)
    protected $fillable = [
        'user_id',          // Зовнішній ключ на User
        'make',             // Марка транспортного засобу
        'model',            // Модель транспортного засобу
        'price',            // Ціна позики
        'repayment_duration', // Тривалість погашення позики (в місяцях)
        'interest_rate',    // Процентна ставка позики
        'total_payment',    // Загальна сума до сплати (основна сума + відсотки)
        'total_interest',   // Загальна сума відсотків
        'monthly_payment',  // Щомісячний платіж
    ];

    // Зв'язок з User
    public function user()
    {
        // Кожна позика належить одному користувачеві
        return $this->belongsTo(User::class); // Зовнішній ключ 'user_id' вказує на модель User
    }
}

