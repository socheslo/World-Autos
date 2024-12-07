<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vehicle;

class UpdateVehicleImages extends Command
{
    protected $signature = 'vehicles:update-images'; // Назва команди
    protected $description = 'Update vehicle images to correct format';

    public function handle()
    {
        // Отримуємо всі записи, які потребують оновлення
        $vehicles = Vehicle::all();

        foreach ($vehicles as $vehicle) {
            // Якщо ім'я файлу не починається з "veh-", припустимо, що це статичне зображення
            if (!str_contains($vehicle->image, 'veh-')) {
                // Оновлюємо ім'я файлу на приклад: veh-01.jpg
                $vehicle->image = 'veh-' . str_pad($vehicle->id, 2, '0', STR_PAD_LEFT) . '.jpg';
                $vehicle->save();
                $this->info("Updated vehicle ID {$vehicle->id} with image {$vehicle->image}");
            }
        }

        $this->info('All vehicle images updated successfully.');
    }
}
