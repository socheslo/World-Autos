<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $table = 'loans';

    // Поля, які дозволено заповнювати
    protected $fillable = [
        'user_id',          // Зовнішній ключ на User
        'make',
        'model',
        'price',
        'repayment_duration',
        'interest_rate',
        'total_payment',
        'total_interest',
        'monthly_payment',
    ];

    // Зв'язок з User
    public function user()
    {
        return $this->belongsTo(User::class); // Кожна позика належить користувачеві
    }
}
