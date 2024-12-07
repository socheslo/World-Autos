<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearVehicles extends Command
{
    /**
     * Назва команди.
     */
    protected $signature = 'vehicles:clear';

    /**
     * Опис команди.
     */
    protected $description = 'Clear all user-added vehicles from the database';

    /**
     * Виконання команди.
     */
    public function handle()
    {
        DB::table('vehicles')->truncate(); // Очищення таблиці vehicles
        $this->info('All user-added vehicles have been cleared.');
    }
}
