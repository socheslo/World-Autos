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
            // Створення автоматичного первинного ключа для таблиці (ідентифікатор транспортного засобу)
            $table->id();

            // Створення стовпця для марки автомобіля
            $table->string('make'); 
            
            // Створення стовпця для моделі автомобіля
            $table->string('model'); 
            
            // Створення стовпця для року випуску автомобіля
            $table->year('year'); 

            // Створення стовпця для пробігу автомобіля
            $table->integer('mileage'); 
            
            // Створення стовпця для ціни автомобіля
            $table->decimal('price', 10, 2); 

            // Створення стовпця для зберігання шляху до зображення транспортного засобу
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
