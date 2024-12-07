<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Поля, які дозволено заповнювати
    protected $fillable = [
        'username', // Ім'я користувача
        'email',    // Електронна пошта
        'password', // Пароль
    ];

    // Сховані поля
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Зв'язок з Loan
    public function loans()
    {
        return $this->hasMany(Loan::class); // Один користувач може мати багато позик
    }
}
