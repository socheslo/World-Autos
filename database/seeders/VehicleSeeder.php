<?php

use Illuminate\Database\Seeder;
use App\Models\Vehicle;

class VehicleSeeder extends Seeder
{
    public function run()
    {
        Vehicle::create([
            'make' => 'Astro',
            'model' => 'Estrella',
            'year' => 2021,
            'mileage' => 500,
            'price' => 50000.00,
            'image' => 'veh-01.jpg',
        ]);

        Vehicle::create([
            'make' => 'Terraza',
            'model' => 'Spinneo',
            'year' => 2020,
            'mileage' => 30000,
            'price' => 31000.00,
            'image' => 'veh-02.jpg',
        ]);
    }
}

