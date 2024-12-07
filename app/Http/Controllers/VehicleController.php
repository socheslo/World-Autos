<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
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

        // Автомобілі, додані користувачами
        $userVehicles = Vehicle::all();

        // Об'єднання всіх транспортних засобів
        $vehicles = collect($defaultVehicles)->merge($userVehicles);

        // Повернення вигляду
        return view('vehicles.index', compact('vehicles'));
    }

    public function showAddVehicleForm()
    {
        return view('vehicles.add');
    }

    public function storeVehicle(Request $request)
    {
        // Валідація
        $validatedData = $request->validate([
            'make' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|integer|min:1886|max:' . date('Y'),
            'mileage' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Збереження зображення
        $path = $request->file('image')->store('vehicles', 'public');

        // Збереження даних у базу
        Vehicle::create([
            'make' => $validatedData['make'],
            'model' => $validatedData['model'],
            'year' => $validatedData['year'],
            'mileage' => $validatedData['mileage'],
            'price' => $validatedData['price'],
            'image' => $path,
        ]);

        return redirect()->route('home')->with('success', 'Vehicle added successfully!');
    }
}
