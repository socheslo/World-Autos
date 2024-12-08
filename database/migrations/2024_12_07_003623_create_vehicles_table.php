<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            // Створюється автоматичний первинний ключ для таблиці (ідентифікатор транспортного засобу)
            $table->id(); 

            // Створюється стовпець для марки автомобіля
            $table->string('make'); 

            // Створюється стовпець для моделі автомобіля
            $table->string('model'); 

            // Створюється стовпець для року випуску автомобіля
            $table->integer('year'); 

            // Створюється стовпець для пробігу автомобіля
            $table->integer('mileage'); 

            // Створюється стовпець для ціни автомобіля
            $table->decimal('price', 10, 2); 

            // Створюється стовпець для шляху до зображення автомобіля
            $table->string('image'); 

            // Додає автоматичні стовпці для часу створення та оновлення запису
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Якщо таблиця 'vehicles' існує, її можна видалити
        Schema::dropIfExists('vehicles'); 
    }
};


