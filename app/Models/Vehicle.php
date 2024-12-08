<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    // Поля, які дозволено заповнювати (масова присвоєння)
    protected $fillable = [
        'make',      // Марка автомобіля
        'model',     // Модель автомобіля
        'year',      // Рік випуску автомобіля
        'mileage',   // Пробіг автомобіля
        'price',     // Ціна автомобіля
        'image',     // Шлях до зображення автомобіля
    ];
}

