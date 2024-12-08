<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    // Метод для відображення всіх транспортних засобів
    public function index()
    {
        // Попередньо визначені транспортні засоби
        $defaultVehicles = [
            (object)[
                'make' => 'Astro',
                'model' => 'Estrella',
                'year' => 2021,
                'mileage' => 500,
                'price' => 50000,
                'image' => 'veh-01.jpg',
            ],
            (object)[
                'make' => 'Terraza',
                'model' => 'Spinneo',
                'year' => 2020,
                'mileage' => 30000,
                'price' => 31000,
                'image' => 'veh-02.jpg',
            ],
            (object)[
                'make' => 'Sage',
                'model' => 'Ecostar',
                'year' => 2014,
                'mileage' => 70000,
                'price' => 15000.00,
                'image' => 'veh-03.jpg',
            ],
            (object)[
                'make' => 'Hauler',
                'model' => 'Lion',
                'year' => 2021,
                'mileage' => 200,
                'price' => 40000.00,
                'image' => 'veh-04.jpg',
            ],
        ];

        // Транспортні засоби, додані користувачами
        $userVehicles = Vehicle::all();

        // Об'єднання стандартних та користувацьких транспортних засобів
        $vehicles = collect($defaultVehicles)->merge($userVehicles);

        // Повернення вигляду з усіма транспортними засобами
        return view('vehicles.index', compact('vehicles'));
    }

    // Метод для відображення форми додавання нового транспортного засобу
    public function showAddVehicleForm()
    {
        return view('vehicles.add');
    }

    // Метод для збереження нового транспортного засобу
    public function storeVehicle(Request $request)
    {
        // Валідація вхідних даних
        $validatedData = $request->validate([
            'make' => 'required|string', // Марка автомобіля повинна бути рядком
            'model' => 'required|string', // Модель автомобіля повинна бути рядком
            'year' => 'required|integer|min:1886|max:' . date('Y'), // Рік повинен бути цілим числом між 1886 і поточним роком
            'mileage' => 'required|integer|min:0', // Пробіг має бути цілим числом і не менше 0
            'price' => 'required|numeric|min:0', // Ціна повинна бути числом і не менше 0
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Зображення має бути файлом одного з допустимих форматів і не перевищувати 2 МБ
        ]);

        // Збереження зображення на сервері
        $path = $request->file('image')->store('vehicles', 'public');

        // Збереження даних транспортного засобу в базі даних
        Vehicle::create([
            'make' => $validatedData['make'], // Марка автомобіля
            'model' => $validatedData['model'], // Модель автомобіля
            'year' => $validatedData['year'], // Рік випуску
            'mileage' => $validatedData['mileage'], // Пробіг
            'price' => $validatedData['price'], // Ціна
            'image' => $path, // Шлях до збереженого зображення
        ]);

        // Перенаправлення на головну сторінку з повідомленням про успішне додавання
        return redirect()->route('home')->with('success', 'Vehicle added successfully!');
    }
}

